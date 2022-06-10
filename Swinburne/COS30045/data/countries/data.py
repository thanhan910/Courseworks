import pandas as pd
import world_bank_data as wb

## Entities

# read entities dataset
df_entities = pd.read_csv("entities/entities.csv")


## Our World in Data

# load the dataset
df_owid = pd.read_csv("https://raw.githubusercontent.com/owid/energy-data/master/owid-energy-data.csv")

### Transform data

# transform year to int data type
# this is so that iso_code + year can be compatible primary keys with the world bank dataset
df_owid["year"] = df_owid["year"].transform(int)

# remove country column
# We already have defined the country names in the "entities" table
df_owid.drop(columns="country", inplace=True)

#### Transform iso_code to Entities Code

# transform iso code to Entities Code

# df_entities Code and OWID
df_entities[["Code", "OWID"]]

#  merge df_owid with df_entities[["Code", "OWID"]]
df_owid = pd.merge(df_entities[["Code", "OWID"]], df_owid, how="right", left_on="Code", right_on="iso_code")

# transform iso_code to standard df_entities Code
df_owid["iso_code"] = df_owid["Code"]

# remove Code and OWID
# we can ensure that this cannot affect the original OWID dataset, since there is no variable in the dataset name "Code" or "OWID"
df_owid.drop(columns=["Code", "OWID"], inplace=True)

### Melt the dataset
# melt dataset and remove nan values

# melt the dataset
df_owid = pd.melt(df_owid, id_vars=["iso_code", "year"], var_name="attr", value_name="owid")

# remove nan values
df_owid.dropna(inplace=True)

## World Bank

### Collect data

# set a dictionary of indicator codes
# each value of the indicator code is the name of the variable in our final dataset
IndicatorCodes = {
    "AG.LND.TOTL.K2": "area",
    "SP.POP.TOTL": "population",
    "NY.GDP.MKTP.CD": "gdp",
    "NY.GDP.MKTP.PP.CD": "gdp_ppp",
    "NY.GDP.PCAP.CD": "gdp_per_captia",
    "NY.GDP.PCAP.PP.CD": "gdp_ppp_per_capita",
}

# get all indicator codes datasets
list_df = []

for indicator_code in IndicatorCodes:
    # get series
    df: pd.Series = wb.get_series(indicator=indicator_code, id_or_value="id")
    # trasnform to dataframe with name Value
    df = df.to_frame("Value")
    # reset index to transform into a normal
    df.reset_index(inplace=True)
    # add to df list
    list_df.append(df)

df_wb = pd.concat(list_df)
df_wb

# then, delete unwanted values
del list_df, df, indicator_code

### Transform data

# rename "Series" value 
# in order to match variable value with OWID data
df_wb["Series"] = df_wb["Series"].transform(lambda x: IndicatorCodes[x])

# remove nan values
df_wb.dropna(inplace=True)

# rename column, prepare to join with df_owid
df_wb.rename(columns={
    "Country": "iso_code",
    "Year": "year",
    "Series": "attr",
    "Value": "wb"
}, inplace=True)


# transform year to int data type
# this is so that iso_code + year can be compatible primary keys with the owid dataset
df_wb["year"] = df_wb["year"].transform(int)


### Transform iso_code to Entity Code

# df_entities Code and OWID
df_entities[["Code", "WB"]]

#  merge df_owid with df_entities[["Code", "OWID"]]
df_wb = pd.merge(df_entities[["Code", "WB"]], df_wb, how="right", left_on="Code", right_on="iso_code")

# transform iso_code to standard df_entities Code
df_wb["iso_code"] = df_wb["Code"]

# remove Code and WB
df_wb.drop(columns=["Code", "WB"], inplace=True)

# remove nan values
df_wb.dropna(inplace=True)

### Merge OWID and WB data
# merge owid and wb data

# merge df_owid with df_wb
df = pd.merge(df_owid, df_wb, how="outer", on=["iso_code", "year", "attr"])

# merge two values from two different datasets
# we prioritize wb values
df["value"] = df["wb"].fillna(df["owid"])


# remove owid and wb, only keep value
df = df[["iso_code", "year", "attr", "value"]]

## Entities Groups

# variables needed
# variables name and matching column in Entities dataset
vars = {
    "iso_code": "Code",
    "country": "Entity",
    "group_OWID_Continent": "OWID_Continent",
    "group_UN_Region": "OWID_UN_Region",
    "group_WHO_Region": "OWID_WHO_Region",
    "group_WB_region": "WB_region",
    "group_WB_adminregion": "WB_adminregion",
    "group_WB_incomeLevel": "WB_incomeLevel",
    "group_WB_lendingType": "WB_lendingType",
    "group_WB_longitude": "WB_longitude",
    "group_WB_latitude": "WB_latitude"
}

# variables of group type
# each of these variable will have a twin variable with the US's value always equals United States
# this is so that in the visualisation, the US can be highlighted
vars_group = [
    "group_OWID_Continent",
    "group_UN_Region",
    "group_WHO_Region",
    "group_WB_region",
    "group_WB_adminregion",
    "group_WB_incomeLevel",
    "group_WB_lendingType"
]


# create df_groups

df_groups = pd.DataFrame()

for k in vars:

    df_groups[k] = df_entities[vars[k]]


# add twin attributes that prioritize US

for k in vars_group:

    df_groups[k + "_exclude_US"] = df_groups[k]

    df_groups.loc[df_groups["country"] == "United States", k + "_exclude_US"] = "United States"

# add a variable that equals United States if and only if the Entity is United States

df_groups["group_is_USA"] = df_groups["country"].copy(deep=True).transform(lambda x: x if x == "United States" else "Other Entities")

# remove not needed variables in this script
del vars, vars_group, k, IndicatorCodes

## Final

# pivot dataset
df = pd.pivot(df, index=["iso_code", "year"], columns="attr", values="value")

# reset index
# reset index to make iso_code and year become normal attributes again
df.reset_index(inplace=True)

# merge values dataset with groups dataset
df = pd.merge(df_groups, df, on="iso_code", how="right")

# write dataset to json
df.to_json("data.json", orient="records")

# write dataset to csv
df.to_csv("data.csv", index=False)