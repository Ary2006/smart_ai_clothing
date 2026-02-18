import os

# --- FIX 1: Silence TensorFlow Logs (Must be before importing tensorflow) ---
os.environ['TF_CPP_MIN_LOG_LEVEL'] = '3' 

import numpy as np
import pickle
import tensorflow as tf
from tensorflow.keras.applications.mobilenet_v2 import MobileNetV2, preprocess_input
from tensorflow.keras.preprocessing import image
from tensorflow.keras.models import Model

# --- CONFIGURATION ---
# Path to product images (relative to this script)
IMAGES_DIR = os.path.join(os.path.dirname(__file__), '../uploads/products')
# Path to save the extracted features
VECTORS_DIR = os.path.join(os.path.dirname(__file__), 'vectors')
OUTPUT_FILE = os.path.join(VECTORS_DIR, 'features.pkl')

# Ensure vectors directory exists
if not os.path.exists(VECTORS_DIR):
    os.makedirs(VECTORS_DIR)

def load_model():
    """Load MobileNetV2 pre-trained on ImageNet."""
    print("Loading AI Model (MobileNetV2)...")
    
    # --- FIX 2: Added input_shape to stop the UserWarning ---
    base_model = MobileNetV2(
        weights='imagenet', 
        include_top=False, 
        pooling='avg', 
        input_shape=(224, 224, 3)
    )
    return base_model

def extract_features(model, img_path):
    """Load and preprocess an image, then extract features."""
    try:
        # 1. Load image and resize to 224x224
        img = image.load_img(img_path, target_size=(224, 224))
        
        # 2. Convert to array
        img_array = image.img_to_array(img)
        
        # 3. Expand dimensions
        img_array = np.expand_dims(img_array, axis=0)
        
        # 4. Preprocess input
        img_array = preprocess_input(img_array)
        
        # 5. Get features
        features = model.predict(img_array, verbose=0)
        
        return features.flatten()
    except Exception as e:
        print(f"Error processing {os.path.basename(img_path)}: {e}")
        return None

def main():
    model = load_model()
    feature_dict = {}

    print(f"Scanning images in {IMAGES_DIR}...")
    
    # Get all valid image files
    valid_extensions = ('.jpg', '.jpeg', '.png', '.webp')
    files = [f for f in os.listdir(IMAGES_DIR) if f.lower().endswith(valid_extensions)]
    
    total_files = len(files)
    if total_files == 0:
        print("No images found! Check your uploads/products folder.")
        return

    for i, filename in enumerate(files):
        img_path = os.path.join(IMAGES_DIR, filename)
        
        features = extract_features(model, img_path)
        
        if features is not None:
            feature_dict[filename] = features
            print(f"[{i+1}/{total_files}] Processed: {filename}")

    # Save the feature dictionary
    print(f"Saving features to {OUTPUT_FILE}...")
    with open(OUTPUT_FILE, 'wb') as f:
        pickle.dump(feature_dict, f)
    
    print("Done! Feature extraction complete.")

if __name__ == "__main__":
    main()