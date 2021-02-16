<?php
    if(isset($_COOKIE['toast_message'])){

        $toast_message =  $_COOKIE['toast_message'];
        setcookie('toast_message', null, -1, '/'); 
        unset($_COOKIE['toast_message']);

        echo "<style>
                .toast{
                    opacity: 0;
                    display: block;
                    position: fixed;
                    width: 300px;
                    bottom: 20;
                    left: 20;
                    z-index: 1000;

                    animation-name: toast;
                    animation-duration: 4s;
                    animation-iteration-count: 1;
                    animation-direction: alternate; /* or: normal */
                    animation-timing-function: ease-out; /* or: ease, ease-in, ease-in-out, linear, cubic-bezier(x1, y1, x2, y2) */
                    animation-fill-mode: forwards; /* or: backwards, both, none */
                    animation-delay: 200ms; /* or: 1s */
                }

                @keyframes toast {
                    0% {
                        opacity: 0;
                    }
                    15%{
                        opacity: 1;
                    }
                    85%{
                        opacity: 1;
                    }
                    100% {
                        opacity: 0;
                    }
                }
            </style>
        
            <div class='toast is-black padding-x-25 padding-y-20 radius-10'>".$toast_message."</div>";
    }