import { initializeApp } from "https://www.gstatic.com/firebasejs/10.4.0/firebase-app.js";
import { getAuth, signInWithPopup, GoogleAuthProvider, FacebookAuthProvider} from "https://www.gstatic.com/firebasejs/10.4.0/firebase-auth.js";

const firebaseConfig = {
    apiKey: "AIzaSyBMAVCgL730O_-t7DFthLsn7udTLZdEHDA",
    authDomain: "mis-helpdesk-beceb.firebaseapp.com",
    projectId: "mis-helpdesk-beceb",
    storageBucket: "mis-helpdesk-beceb.appspot.com",
    messagingSenderId: "334091397492",
    appId: "1:334091397492:web:3af610a955cee963246421",
    measurementId: "G-3TCK1Q6S04"
};

const app = initializeApp(firebaseConfig);
const auth = getAuth();
const googleProvider = new GoogleAuthProvider();
const facebookProvider = new FacebookAuthProvider();

$("#googleAuth").click(e => {
    e.preventDefault();
    signInWithPopup(auth, googleProvider).
    then((result) => {
        console.log(result);
    }).catch((error) => {

    });
});

$("#facebookAuth").click(e => {
    e.preventDefault();
    signInWithPopup(auth, facebookProvider).
    then((result) => {
        console.log(result);
    }).catch((error) => {
        console.log(error);
    });
});
