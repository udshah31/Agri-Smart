import pandas as pd
import json

print("Reading comprehensive dataset...")
df = pd.read_csv("ML/yield_prediction/crop_production_india.csv")
df['Season'] = df['Season'].str.strip()

cropOptions = {}

for dist, group in df.groupby('District_Name'):
    cropOptions[dist] = {}
    for season, sgroup in group.groupby('Season'):
        cropOptions[dist][season] = list(sgroup['Crop'].unique())

print("Updating state_district_crops_dropdown.js...")
js_content = "const cropOptions = " + json.dumps(cropOptions, indent=2) + ";\n"

with open("assets/js/state_district_crops_dropdown.js", "r") as f:
    lines = f.readlines()

for idx, line in enumerate(lines):
    if line.startswith("const cropOptions"):
        lines = lines[:idx]
        break

with open("assets/js/state_district_crops_dropdown.js", "w") as f:
    f.writelines(lines)
    f.write("\n" + js_content)

print("Done! JavaScript file successfully updated.")
