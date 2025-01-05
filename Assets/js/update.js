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
const user = auth.currentUser;

function updateProfile(user){

        const usename = user.displayName;
        const useremail = user.email;
        const userprofile = user.photoURL;

        document.getElementById("username").textContent = usename;
        document.getElementById("useremail").textContent = useremail;
        document.getElementById("userprofile").textContent = userprofile;

}

onAuthStateChange(auth,(user)=>{
    if(user()){
        updateProfile(user);
        const uid =user.uid;
        return uid;

    }else{
        alert("Create Account & Login");
        // window.location.href="/registration.php";

    }
})