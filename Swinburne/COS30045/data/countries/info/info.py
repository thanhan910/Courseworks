import pandas as pd

df_info = pd.read_excel("info.xlsx", sheet_name="info")
df_info.set_index("value", drop=False, inplace=True)

df_order = pd.read_excel("info.xlsx", sheet_name="order")
df_order = df_order.apply(lambda x: x.dropna().tolist()).to_frame("order")

df = pd.merge(df_info, df_order, left_index=True, right_index=True, how="left")
df.agg(lambda x: x.dropna().to_dict(), axis=1).to_json("info.json")