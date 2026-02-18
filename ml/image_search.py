import sys
import os
import json
import pickle
import numpy as np

# Suppress TensorFlow logs (makes PHP output cleaner)
os.environ['TF_CPP_MIN_LOG_LEVEL'] = '3' 

from tensorflow.keras.applications.mobilenet_v2 import MobileNetV2, preprocess_input
from tensorflow.keras.preprocessing import image
from sklearn.metrics.pairwise import cosine_similarity

# --- CONFIGURATION ---
VECTORS_FILE = os.path.join(os.path.dirname(__file__), 'vectors', 'features.pkl')

def load_features():
    """Load the pre-computed feature vectors."""
    if not os.path.exists(VECTORS_FILE):
        return None
    with open(VECTORS_FILE, 'rb') as f:
        return pickle.load(f)

def extract_features(model, img_path):
    """Extract features from the query image."""
    try:
        img = image.load_img(img_path, target_size=(224, 224))
        img_array = image.img_to_array(img)
        img_array = np.expand_dims(img_array, axis=0)
        img_array = preprocess_input(img_array)
        
        features = model.predict(img_array, verbose=0)
        return features.flatten()
    except Exception as e:
        return None

def main():
    # 1. Get the image path from PHP arguments
    if len(sys.argv) < 2:
        print(json.dumps({"error": "No image path provided"}))
        return

    query_img_path = sys.argv[1]

    if not os.path.exists(query_img_path):
        print(json.dumps({"error": f"File not found: {query_img_path}"}))
        return

    # 2. Load Resources
    features_dict = load_features()
    if not features_dict:
        print(json.dumps({"error": "No product features found. Run generate_vectors.py first."}))
        return

    # Load Model (MobileNetV2)
    # Note: Loading the model takes 1-2 seconds.
    model = MobileNetV2(weights='imagenet', include_top=False, pooling='avg', input_shape=(224, 224, 3))

    # 3. Extract features for the query image
    query_vector = extract_features(model, query_img_path)
    if query_vector is None:
        print(json.dumps({"error": "Failed to process query image"}))
        return

    # 4. Compare with database (Cosine Similarity)
    results = []
    query_vector = query_vector.reshape(1, -1) # Reshape for scikit-learn

    for filename, saved_vector in features_dict.items():
        saved_vector = saved_vector.reshape(1, -1)
        # Calculate similarity (0 to 1, where 1 is identical)
        similarity = cosine_similarity(query_vector, saved_vector)[0][0]
        results.append((filename, float(similarity)))

    # 5. Sort by similarity (highest first)
    results.sort(key=lambda x: x[1], reverse=True)

    # 6. Return top 5 matches as JSON
    # PHP will decode this JSON to show the products
    top_matches = [{"image": r[0], "score": r[1]} for r in results[:5]]
    
    print(json.dumps(top_matches))

if __name__ == "__main__":
    main()