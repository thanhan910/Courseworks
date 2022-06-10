
# # US States Energy Data
# 
# This dataset contains all energy data of the US and its states and territories.
# The dataset is sourced from EIA's State Energy Data System.


# ## Dataset
# 
# Update: June 10th, 2022. 10:00 pm
# 
# This section will elaborate on the data processing process.
# 
# We used a consolidated data file of more than 1.8 million records that is available on EIA's SEDS [seds-data-complete website](https://www.eia.gov/state/seds/seds-data-complete.php?sid=US).
# 
# **Note**: For this notebook, We used the file that contains records from 1960-2019. The file can be downloaded [here](https://www.eia.gov/state/seds/CDF/Complete_SEDS.csv) 
# 
# There is an updated file that contains the data from 1960-2020, available on EIA's SEDS updated [website](https://www.eia.gov/state/seds/seds-data-fuel.php?sid=US) website. The file can be downloaded using this [link](https://www.eia.gov/state/seds/sep_update/Complete_SEDS_update.csv).


import pandas as pd


# ### Read and Clean the dataset


# read the dataset dictionary (info, calc)
df = pd.read_excel("info/info.xlsx", sheet_name=['info', 'calc'])
df_info = df["info"]
df_calc = df["calc"]


# read the source dataset
df_data = pd.read_csv("https://www.eia.gov/state/seds/CDF/Complete_SEDS.csv")
df_data

# drop Data_Status
# we don't need it since Data_Status all equals 2019F
# to verify it, split this cell in this line here and run 
# ```
# df_data["Data_Status"].drop_duplicates()
# ```
df_data = df_data.drop(columns="Data_Status")
df_data

# select only needed MSN
df_data = df_data[df_data["MSN"].isin(df_calc["Variable"].to_list())]
df_data

# pivot the dataset
df_data = pd.pivot(df_data, index=["StateCode", "Year"], columns="MSN", values="Data")
df_data

# reset index so that the pivoted dataset becomes a normal table again
df_data.reset_index(inplace=True)
df_data



# ### Calculate Variables
# 
# Our strategy is as follows: for each variable, if all of its sub-variables are already calculated in the dataset, then we calculate that variable. If not, we skip to the next variable.


# transform calc to series of value in dict type
sf_calc = df_calc.groupby(["id"]).apply(
    lambda x: 
    x[["Variable", "Coefficient"]]
    .set_index("Variable")
    .transpose()
    .loc["Coefficient"]
    .to_dict()
)
sf_calc


# calculate the variables

# Our strategy is as follows: for each variable, if all of its sub-variables are already calculated in the dataset, then we calculate that variable. If not, we skip to the next variable.

# number of variables still needed to calculte. By default it equals the number of variables to calculate
to_calculate = len(sf_calc)

while(to_calculate > 0):

    # a dictionary that holds all variables
    d_to_calculate = {}

    for var in sf_calc.index:
        if(var in df_data.columns): 
            sf_calc.drop(var)
            continue

        if(all(x in df_data.columns for x in sf_calc[var].keys())):
            d_to_calculate[var] = sf_calc[var]
            df_data[var] = 0

    to_calculate = len(d_to_calculate)
    
    if(to_calculate == 0): break

    for var in d_to_calculate:
        for subvar in d_to_calculate[var]:
            df_data[var] += df_data[subvar].fillna(0) * d_to_calculate[var][subvar]

df_data


# keep only our needed variables
df_data = df_data[["StateCode", "Year"] + df_info["id"].tolist()]
df_data


# ### Write the dataset to files


# write data to json
df_data.groupby("StateCode").apply(
    lambda x:
    x.set_index("Year", drop=False)
    .to_dict("index")
).to_json("data.json")


# write data to csv
df_data.to_csv("data.csv", index=False)


