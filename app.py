from flask import Flask, request, jsonify
import joblib

app = Flask(__name__)

model = joblib.load("sp2d_classifier.pkl")

@app.route('/predict', methods=['POST'])
def predict():
    data = request.json
    text = data.get("text", "")
    if not text:
        return jsonify({"error": "No text provided"}), 400
    prediction = model.predict([text])
    return jsonify({"kategori": prediction[0]})

if __name__ == '__main__':
    app.run(debug=True)
