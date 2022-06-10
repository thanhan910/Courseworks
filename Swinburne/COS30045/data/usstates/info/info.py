
# # US States Energy Data
# 
# This dataset contains all energy data of the US and its states and territories.
# The dataset is sourced from EIA's State Energy Data System.


# ## Data Dictionary (Info)
# 
# Update: June 10th, 2022. 10:00pm
# 
# This section will evaluate the transition of info from Excel worksheets to usable files in an application.
# 
# The calculation of the algorithms of the variables is done by reviewing EIA's SEDS [Codes and Documentation](https://www.eia.gov/state/seds/seds-data-complete.php?sid=US) (download the xlsx file [here](https://www.eia.gov/state/seds/CDF/Codes_and_Descriptions.xlsx)), [Technical Notes and Documentation](https://www.eia.gov/state/seds/seds-technical-notes-complete.php?sid=US), and [Data and methodology changes](https://www.eia.gov/state/seds/seds-data-changes.php?sid=US)
# 
# For the 2020 update, the new Technical Notes and Documentation is available on [this website](https://www.eia.gov/state/seds/seds-technical-notes-updates.php?sid=US), and the new Codes and Description is available [here](https://www.eia.gov/state/seds/seds-data-complete.php?sid=US) (download the xlsx file [here](https://www.eia.gov/state/seds/CDF/Codes_and_Descriptions.xlsx))
# 


import pandas as pd


# ### Load info and calc from the Excel book 
# 
# `df_info` is the table containing all information of all neeeded variables of the dataset.
# 
# `df_calc` is the table that list the calculation method of each variable.
# 
# `df_groups` is the table that list all groups and subgroups (parents and childs)


# read files
# load info and calc from Excel book
df = pd.read_excel("info.xlsx", sheet_name=['info', 'calc'])
df_info = df["info"]
df_calc = df["calc"]

# set df_info index as id
df_info.set_index("id", drop=False, inplace=True)
df_info


# ### Load groups table


# retrieve df_groups from df_calc
# (parents and childs)

# list of groups
list_groups = df_info[df_info["type"] == "group"]["id"].tolist()

# df_groups
df_groups = df_calc[df_calc["id"].isin(list_groups)]
df_groups

del list_groups # remove not needed variables of this script


# ### Calculate groups leafs
# 
# Identify the leafs of each group. Each group is the sum of a set of subgroups.
# 
# For example:
# ```py
# Total = Renewables + FossilFuel + Nuclear
# ```
# 
# We need to calculate each group's set of leafs (nodes), for easier data manipulations in the visualisation, especially the links.
# 
# Our strategy is as follows: If all subgroups of a group already had their leafs calculated (or are leafs themselves), then the leafs of the group is the sum of all leafs of the subgroups. The order of calculations will be from the leafs, to the parents in low level, to the parents in higher levels, and so on.


# create a pd.Series dictionary that records a list of leafs for each group
# except for nodes, each node's value in this Series equals a list of itself (node: [node])
# this is used for easier list additions

# list of all nodes
list_nodes= df_info[df_info["type"].isin(["node"])]['id'].tolist()
list_nodes

# series of leafs
sf_leafs = pd.Series({i:[i] for i in list_nodes})
sf_leafs


# create a Series that records the list of subgroups (childs) of each group (parent)
sf_hierarchy = df_groups.groupby("id").apply(lambda x: x["Variable"].tolist())
sf_hierarchy


# calculate the leafs of each group

# Our strategy is as follows:
# If all subgroups of a group already had their leafs calculated (or are leafs themselves), then the leafs of the group is the sum of all leafs of the subgroups
# The order of calculations will be from the leafs, to the parents in low level, to the parents in higher levels, and so on

# number of groups still needed to be identified the leafs
# by default, it is the total number of groups
to_calculate = len(sf_hierarchy)

while(to_calculate > 0):
    
    # a dictionary of all groups that are eligible to be calculated (have all subgroups/leafs calculated)
    d_to_calculate = {}

    # search for all groups that are eligible to be calculated
    for index, value in sf_hierarchy.iteritems():

        # skip if the group has already been calculated
        if(index in sf_leafs.index): 
            sf_hierarchy.drop(index)
            continue

        # if all subgroups have been calculated, but the group is not calculated, then add the group to the to be calculated dictionary
        if(all(v in sf_leafs.index for v in value)): 
            d_to_calculate[index] = value

    # check how many groups have just been calculated. if 0 (no more groups needed to calculate), then break. 
    to_calculate = len(d_to_calculate)

    if(to_calculate == 0): break

    # calculate the leafs of each group
    for index, value in d_to_calculate.items():

        # initialize list
        sf_leafs[index] = []

        # aggregate the set of leafs of each subgroup of the group
        for v in value:
            sf_leafs[index] += sf_leafs[v]


sf_leafs



# remove nodes from sf_leafs
# the nodes only serves as a method for calculations
sf_leafs = sf_leafs.drop(labels=list_nodes)
sf_leafs


# ### Merge the calculated leafs data to info


# merge sf_leafs to df_info
df_info = pd.merge(df_info, sf_leafs.to_frame("leafs"), how="left", left_index=True, right_index=True)
df_info


# ### Write info to files


# write df_info to json
# remove every key with nan values before writing to json
df_info.agg(lambda x: x.dropna().to_dict(), axis=1).to_json("info.json")


# write df_info to csv
df_info.to_csv("info.csv", index=False)


