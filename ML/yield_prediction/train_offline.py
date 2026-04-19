import pandas as pd
import numpy as np
import joblib
from sklearn.ensemble import RandomForestRegressor
from sklearn.model_selection import train_test_split
from sklearn.preprocessing import OneHotEncoder
import os

print("Loading comprehensive dataset for Yield Prediction...")
df = pd.read_csv("ML/yield_prediction/crop_production_india.csv")

# Clean up season strings
df['Season'] = df['Season'].str.strip()

# Drop the Crop_Year column as per original structure
df = df.drop(['Crop_Year'], axis=1)

# Separate the features and target variables
X = df.drop(['Production'], axis=1)
y = df['Production']

# Split the data into training and testing sets
print("Splitting data...")
X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)

# Categorical columns for one-hot encoding
categorical_cols = ['State_Name', 'District_Name', 'Season', 'Crop']

# One-hot encode the categorical columns
print("Encoding categorical attributes...")
ohe = OneHotEncoder(handle_unknown='ignore')
ohe.fit(X_train[categorical_cols])

# Convert categorical columns to one-hot encoding
X_train_categorical = ohe.transform(X_train[categorical_cols])

# Combine the one-hot encoded categorical columns and numerical columns
X_train_final = np.hstack((X_train_categorical.toarray(), X_train.drop(categorical_cols, axis=1)))

# Train the model
print("Training the Random Forest Regressor (Optimized parameters)...")
model = RandomForestRegressor(n_estimators=10, max_depth=20, random_state=42, n_jobs=-1)
model.fit(X_train_final, y_train)

print("Exporting Model to disk...")
joblib.dump(model, "ML/yield_prediction/yield_model.pkl")
joblib.dump(ohe, "ML/yield_prediction/yield_ohe.pkl")

print("Done! offline generation successful.")
