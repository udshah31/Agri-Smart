import numpy as np
import sys
import joblib
import warnings
warnings.filterwarnings("ignore")

# Load the pre-trained model and OneHotEncoder
model = joblib.load("ML/yield_prediction/yield_model.pkl")
ohe = joblib.load("ML/yield_prediction/yield_ohe.pkl")

# Get the input parameters as command line arguments
Jstate = sys.argv[1].strip()
Jdistrict = sys.argv[2].strip()
Jseason = sys.argv[3].strip()
Jcrops = sys.argv[4].strip()
Jarea = float(sys.argv[5].strip())

user_input = np.array([[Jstate, Jdistrict, Jseason, Jcrops, Jarea]], dtype=object)

# Convert the categorical columns to one-hot encoding
user_input_categorical = ohe.transform(user_input[:, :4])

# Combine the one-hot encoded categorical columns and numerical columns
user_input_final = np.hstack((user_input_categorical.toarray(), user_input[:, 4:].astype(float)))

# Make the prediction
prediction = model.predict(user_input_final)

# Return the prediction as a string
print(str(prediction[0]))
