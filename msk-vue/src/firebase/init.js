import firebase from 'firebase'
import firestore from 'firebase/firestore'


var firebaseConfig = {
   apiKey: "AIzaSyDX0CbeJS1LZ-bWEwGbfx3sedNGnmCM5sY",
   authDomain: "msk-messenger.firebaseapp.com",
   databaseURL: "https://msk-messenger.firebaseio.com",
   projectId: "msk-messenger",
   storageBucket: "",
   messagingSenderId: "817591830408",
   appId: "1:817591830408:web:d4d8361f2a904c62"
 };
 // Initialize Firebase
 const firebaseApp = firebase.initializeApp(firebaseConfig);


 export default firebaseApp.firestore()
