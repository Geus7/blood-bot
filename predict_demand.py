import pandas as pd
import numpy as np
from sklearn.model_selection import train_test_split
from sklearn.ensemble import RandomForestRegressor
from sklearn.metrics import mean_absolute_error
import joblib
import sys
import os

# Function to load data and train model
def train_model(csv_file):
    # Load dataset
    df = pd.read_csv(csv_file)

    # Data preprocessing
    df['Month'] = df['Month'].astype(int)
    df['Year'] = df['Year'].astype(int)

    # Encode categorical variables
    df = pd.get_dummies(df, columns=['Location', 'BloodType'], drop_first=True)

    # Separate features and target
    X = df.drop(columns=['Demand'])
    y = df['Demand']

    # Split data for training and testing
    X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)

    # Train the model
    model = RandomForestRegressor(n_estimators=100, random_state=42)
    model.fit(X_train, y_train)

    # Evaluate the model
    y_pred = model.predict(X_test)
    mae = mean_absolute_error(y_test, y_pred)
    print(f"Mean Absolute Error on test set: {mae:.2f}")

    # Save the trained model
    joblib.dump(model, 'blood_demand_forecast_model.pkl')

# Function to predict demand
def predict_demand(location, blood_type, month, year):
    # Load model
    model = joblib.load('blood_demand_forecast_model.pkl')

    # Prepare input data for prediction
    input_data = {
        'Month': [month],
        'Year': [year]
    }

    # Create dummy variables for the input
    for col in model.feature_names_in_:
        if col.startswith('Location_'):
            input_data[col] = [1 if col.split('_')[1] == location else 0]
        elif col.startswith('BloodType_'):
            input_data[col] = [1 if col.split('_')[1] == blood_type else 0]
        else:
            input_data[col] = [0]

    # Convert to DataFrame
    input_df = pd.DataFrame(input_data)
    input_df = input_df.reindex(columns=model.feature_names_in_, fill_value=0)

    # Predict demand
    predicted_demand = model.predict(input_df)[0]
    return predicted_demand

if __name__ == "__main__":
    # Ensure the correct number of arguments are passed
    if len(sys.argv) < 6:
        print("Error: Not enough arguments provided.")
        print("Usage: python predict_demand.py <csv_file> <location> <blood_type> <month> <year>")
        sys.exit(1)

    # Load parameters from command line
    csv_file = sys.argv[1]
    location = sys.argv[2]
    blood_type = sys.argv[3]
    month = int(sys.argv[4])  # Month input from PHP
    year = int(sys.argv[5])    # Year input from PHP

    # Train model if it does not exist
    if not os.path.exists('blood_demand_forecast_model.pkl'):
        train_model(csv_file)

    # Perform prediction
    predicted_demand = predict_demand(location, blood_type, month, year)
    print(f"Predicted Demand for {blood_type} blood in {location} for {month}/{year}: {predicted_demand:.2f} units")

