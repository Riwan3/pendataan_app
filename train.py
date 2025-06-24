
import pandas as pd
from sklearn.model_selection import train_test_split
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.naive_bayes import MultinomialNB
from sklearn.pipeline import Pipeline
import joblib

# Load OCR text
with open("hasil-ocr.txt", "r", encoding="utf-8") as f:
    raw_text = f.read()

entries = re.split(r'-{10,}', raw_text)

def extract_info(entry):
    entry = entry.strip()
    if "pemagaran" in entry.lower() or "pembangunan gedung" in entry.lower():
        label = "SP2D_KONSTRUKSI"
    elif "rehabilitasi" in entry.lower():
        label = "SP2D_REHABILITASI"
    elif "perpustakaan" in entry.lower():
        label = "SP2D_PERPUSTAKAAN"
    else:
        label = "LAINNYA"
    return entry, label

data = [extract_info(e) for e in entries if len(e.strip()) > 100]
df = pd.DataFrame(data, columns=["text", "label"])

X_train, X_test, y_train, y_test = train_test_split(df["text"], df["label"], test_size=0.2)

model_pipeline = Pipeline([
    ('tfidf', TfidfVectorizer()),
    ('clf', MultinomialNB())
])
model_pipeline.fit(X_train, y_train)

joblib.dump(model_pipeline, "sp2d_classifier.pkl")
print("Model saved as sp2d_classifier.pkl")
