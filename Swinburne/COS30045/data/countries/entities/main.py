# Countries, Entities, and groups

## Chapter 1: Our World in Data

# First we want to create a dataset of all countries, their ISO codes and regions from Our World in Data. Our main sources would be the OWID's [World map region definitions](https://ourworldindata.org/world-region-map-definitions) page and OWID's [standard entity names](https://github.com/owid/energy-data/tree/master/scripts/input/shared). ([source](https://raw.githubusercontent.com/owid/energy-data/master/scripts/input/shared/iso_codes.csv)). 

# However, these sources did not list all available OWID's entities, so we will also interpolate our dataset with entities listed in OWID's [Energy Data](https://github.com/owid/energy-data) ([source](https://raw.githubusercontent.com/owid/energy-data/master/owid-energy-data.csv)), and [CO2 Data](https://github.com/owid/co2-data) ([source](https://raw.githubusercontent.com/owid/co2-data/master/owid-co2-data.csv))

### World map region definitions

# First, we manually download the datasets from https://ourworldindata.org/world-region-map-definitions and stored them in the "owid" directory.

# Then, we read those downloaded csv file, store each csv table in a DataFrame, and merge the DataFrames together using the Code attribute

import pandas as pd
import os

# read the files

datafiles = []

for dirpath, _, filenames in os.walk("owid"):
    for f in filenames:
        datafiles.append(os.path.join(dirpath, f))
# load each file into a DataFrame

dfs = []

for f in datafiles:
    # drop the Year column since we don't need it
    df = pd.read_csv(f).drop('Year', axis=1)
    dfs.append(df)
# merge all dataframes based on Entity and Code

df_merged = dfs[0]

for df in dfs[1:]:
    df_merged = pd.merge(df_merged, df, on=["Entity", "Code"], how="outer")

### OWID Energy Data

# read the energy data file
df = pd.read_csv("https://raw.githubusercontent.com/owid/energy-data/master/owid-energy-data.csv")


# retrieve all iso codes and countries available in the datafile
df = df[["iso_code", "country"]].drop_duplicates()

# set index as iso code and country
df_owid_energy_data = df.set_index(["iso_code", "country"])

### OWID CO2 Data


# read the OWID CO2 data
df = pd.read_csv("https://raw.githubusercontent.com/owid/co2-data/master/owid-co2-data.csv")



# retrieve all iso codes and countries available in the datafile
df = df[["iso_code", "country"]].drop_duplicates()



# set index as iso code and country
df_owid_co2_data = df.set_index(["iso_code", "country"])



# merge two country lists from energy data and co2 data
df_owid_data = pd.merge(df_owid_energy_data, df_owid_co2_data, how="outer", left_index=True, right_index=True)


### Standard Entity Names


# read the standard entity names file
df = pd.read_csv("https://raw.githubusercontent.com/owid/energy-data/master/scripts/input/shared/iso_codes.csv")


# drop duplicates
df.drop_duplicates(subset="iso_code")

# rename column
df.rename(columns={'Country': 'country'}, inplace=True)


# set index as iso code and country
df_owid_country = df.set_index(["iso_code", "country"])

# merge the standard country dataframe with the owid energy+co2 dataframe
df_owid = pd.merge(df_owid_data, df_owid_country, how="outer",
                    left_index=True, right_index=True)
                    
# reset index
df_owid = df_owid.reset_index()

# rename columns to merge with df_merge
df_owid.rename(columns={'country': 'Entity', 'iso_code': 'Code'}, inplace=True)

# merge with df_merged
df = pd.merge(df_owid, df_merged, how="outer", on=["Entity", "Code"])

### Process with Excel

# output to csv file to process with Excel
df.to_csv("output/owid.csv")

# In the Excel file, we selected any countries without a Code and check if the country is duplicated in the file or not.
# We also added all empty and NaN ISO code values with a specific id, in order not to merge NaN id values with df_wb in the future.
# The cleaning process with Excel was done in the [custom/ProcessBook.xlsx](/custom/ProcessBook.xlsx) file
# After processing with Excel, we reload the file back to continue.

# read the processed data from Excel
df_owid = pd.read_csv("custom/owid.csv")

## Chapter 2: World Bank

import world_bank_data as wb


# get countries available in World Bank database
df_wb = wb.get_countries()

### Merge World Bank data with OWID datas 

# save the World Bank's ISO code to another column before merging with df_owid
df_wb["WB"] = df_wb.index

# Save the Code in the OWID column before merging with df_wb
df_owid["OWID"] = df_owid["Code"]

# merge df_owid with df_wb and write the table to a csv file to process with Excel
df = pd.merge(df_owid, df_wb, how="outer", left_on="Code", right_index=True)
df.to_csv("output/owidwb.csv")

# after this, we have opened the file in excel and clean the data manually

# In the Excel file, we manually checked if there was any conflict between the World Bank dataset and the OWID dataset, and we also check if there were any duplicate countries.
# The cleaning process with Excel was done in the [custom/ProcessBook.xlsx](/custom/ProcessBook.xlsx) file.
# After finished checking and fixing the datasets, we reloaded the file back to continue.

df_owid_wb = pd.read_csv("custom/owid_wb.csv")

# import the Python client
import weo


# read weo dataset
path, url = weo.download(2022, 1, filename="output/weo_2022_1.csv")

#  read all countries available in the WEO dataset 
df_weo: pd.DataFrame = weo.WEO(path).countries()

# select only the ISO column and Country column
df_weo = df_weo[["ISO", "Country"]]

### Merge with WB+OWID dataset

# store the ISO column to the WEO column to prepare for merging with WB+OWID dataset 
df_weo["WEO"] = df_weo["ISO"]

# merge df_weo with df_owid_wb
df = pd.merge(df_owid_wb, df_weo, left_on="Code", right_on="ISO", how="outer")

# write the table back to Excel to continue processing
df.to_csv("output/owid_wb_weo.csv")

# after this, we have opened the file in excel and clean the data manually

# In the Excel file, we checked for conflicts between WEO, WB, and OWID, and check if there were any duplicate countries in the file.
# The cleaning process with Excel was done in the [custom/ProcessBook.xlsx](/custom/ProcessBook.xlsx) file.
# After finished checking and fixing the datasets, we put the final processed dataset in the entities sheet.
# We reload the file back to finalize.

## Final
# Finally, we moved the final dataset in the "entities" Excel sheet to the front, stored it in a csv.

# load the sheet back to df, and write the data to entities.csv
df = pd.read_excel("custom/ProcessBook.xlsx", sheet_name="entities")
df.to_csv("entities.csv", index=False)