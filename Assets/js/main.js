import { initializeApp } from "https://www.gstatic.com/firebasejs/10.10.0/firebase-app.js";
import { getAuth, GoogleAuthProvider,signInWithPopup } from "https://www.gstatic.com/firebasejs/10.10.0/firebase-auth.js";
const firebaseConfig = {
    apiKey: "AIzaSyDvYvpIG35rF6uBSF1gKG_P3jR1NuGJVw0",
    authDomain: "ecovibe-e777e.firebaseapp.com",
    databaseURL: "https://ecovibe-e777e-default-rtdb.firebaseio.com",
    projectId: "ecovibe-e777e",
    storageBucket: "ecovibe-e777e.appspot.com",
    messagingSenderId: "514520571966",
    appId: "1:514520571966:web:ac6cc21421e43e40bb716f"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const auth = getAuth(app);
auth.languageCode = 'en';
const provider = new GoogleAuthProvider();

const googleLogin = document.getElementById("google-login-btn");
googleLogin.addEventListener("click", function() {
    signInWithPopup(auth, provider)
  .then((result) => {

    const credential = GoogleAuthProvider.credentialFromResult(result);
    // const token = credential.accessToken;

    const user = result.user;
    console.log(user);
    window.location.href="../Admin/googledata.php";

  }).catch((error) => {

    const errorCode = error.code;
    const errorMessage = error.message;

    // const email = error.customData.email;

    // const credential = GoogleAuthProvider.credentialFromError(error);
    // ...
  });
});