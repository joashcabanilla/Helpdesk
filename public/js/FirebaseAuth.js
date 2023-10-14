import { initializeApp } from "https://www.gstatic.com/firebasejs/10.4.0/firebase-app.js";
import { getAuth, signInWithPopup, GoogleAuthProvider} from "https://www.gstatic.com/firebasejs/10.4.0/firebase-auth.js";

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

googleProvider.setCustomParameters({
    prompt: 'select_account',
});

$("#googleAuth").click(e => {
    e.preventDefault();
    signInWithPopup(auth, googleProvider).
    then((result) => {
        let email = result.user.email;
        $.ajax({
            type:"POST",
            url:"api/v1/register",
            data: {
                email: email,
                action: 'gmail'
            },
            success: (res) => {
                if(res.message == "success"){
                    $.ajax({
                        type:"POST",
                        url:"postlogin",
                        data:{
                            id:res.id
                        },
                        success: () => {
                            localStorage.setItem("api_token",res.token);
                            location.reload();
                        }
                    });
                }
                else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: res.message,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        confirmButtonColor: "#28a745"
                    }).then((result) => {
                        location.reload();
                    });
                }
            }
        });
    }).catch((error) => {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Gmail Authentication Error',
            allowOutsideClick: false,
            allowEscapeKey: false,
            confirmButtonColor: "#28a745"
        }).then((result) => {
            location.reload();
        });
    });
});
