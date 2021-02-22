<?php

    // Including global constants
    include_once 'config.php';

?>

<div class="outer-container is-white sticky top custom-border-bottom">
    <div class="width-80 float-center">
        <div class="row">

            <!-- Logo Container -->
            <div class="col-30">
                <a href="" class="float-left">
                    <!--<img src="" alt="LOGO" class="padding-15"/>-->
                    <p class="h3 bold padding-15">Veheaven</p>
                </a>
            </div>

            <!-- Search Box Container -->
            <div class="col-40 padding-top-15">
                <form id="search-form" autocomplete="off" novalidate onsubmit="return false;">
                    <input id="search-box" class="radius-5 is-white-95 custom-border" type="search" name="search" placeholder="Search" inputmode="text">
                    <div id="search-suggestion" class="is-white width-100 shadow-20 radius-5" style="display:none; position:absolute; top:40;">
                        <!-- List items will be add in JS -->
                    </div>
                </form>
                <script>
                    function textToNode(text) {
                        var template = document.createElement('template');
                        text = text.trim(); // Never return a text node of whitespace as the result
                        template.innerHTML = text;
                        return template.content.firstChild;
                    }
                    function slugify(text){
                        return text.toString().toLowerCase()
                            .replace(/[^0-9a-zA-Z ]/g, ' ')      // Remove all non-word or non-numeric or non-space chars
                            .trim()                              // Trim starting and ending white-spaces
                            .replace(/\s+/g, '-')                // Remove all other redundant white-spaces and replace with -
                    }

                    const searchForm = document.getElementById('search-form');
                    const searchBox = searchForm.querySelector('#search-box');
                    const searchBoxSuggestion = searchForm.querySelector('#search-suggestion');

                    let keyword = "";

                    // Event to suggest the vehicle name
                    searchBox.oninput = async function(event){
                        keyword = searchBox.value;
                        searchBoxSuggestion.innerText = "";

                        if(keyword.length < 1){
                            //searchBoxSuggestion.appendChild(textToNode("<p class='padding-15 text-center'>Type to search...</p>"));
                            searchBoxSuggestion.style.display = 'none';
                            return;
                        }else{
                            searchBoxSuggestion.appendChild(textToNode("<p class='padding-15 text-center'>Searching ...</p>"));
                            searchBoxSuggestion.style.display = 'block';
                            await fetch('<?=API_ENDPOINT.'/search';?>'+'/7/'+slugify(keyword)) // url
                            .then(response => response.json())
                            .then(data => {
                                searchBoxSuggestion.innerText = "";
                                if(!data || !data.success || !data.content) {
                                    searchBoxSuggestion.appendChild(textToNode("<p class='padding-15 text-center'>No result found</p>"));
                                }else{
                                    // Work on returned content
                                    vehicles = data.content.vehicles;
                                    users = data.content.users;

                                    // For vehicles
                                    for(var i = 0; i<vehicles.length; i++){
                                        searchBoxSuggestion.appendChild(
                                            textToNode(
                                                "<a data-active='0' data-keyword='"+vehicles[i].name+"' href='<?=SERVER_NAME;?>/vehicle/?id="+vehicles[i].id+"' class='width-100 padding-y-10 padding-x-15 custom-border-bottom'>" +
                                                    vehicles[i].name +
                                                "</a>"
                                            )
                                        );
                                    } // For vehicles

                                    // For users
                                    for(var i = 0; i<users.length; i++){
                                        var id = users[i].id;
                                        var name = users[i].firstName+' '+users[i].lastName;
                                        searchBoxSuggestion.appendChild(
                                            textToNode(
                                                "<a data-active='0' data-keyword='"+name+"' href='<?=SERVER_NAME;?>/profile/?id="+id+"' class='width-100 padding-y-10 padding-x-15 custom-border-bottom'>" +
                                                    name +
                                                "</a>"
                                            )
                                        );
                                    } // For users
                                }
                                
                            });
                        }
                    }

                    searchBox.onfocus = () => {
                        if (searchBoxSuggestion.style.display != 'block') searchBoxSuggestion.style.display = 'block';
                    }

                    window.onclick = (event) => {
                        if(!searchForm.contains(event.target)) searchBoxSuggestion.style.display = 'none';
                    }

                    // Event for key (up-arrow,down-arrow) navigation
                    searchBox.onkeydown = searchBoxSuggestion.onkeydown = function(event){
                        if (searchBoxSuggestion.childElementCount == 0 || ![38,40].includes(event.keyCode)) return;

                        var active = searchBoxSuggestion.querySelector('a[data-active="1"]');

                        if(active){
                            active.setAttribute("data-active", "0");
                            active.style.backgroundColor = null;
                        }

                        if(event.keyCode == 38){ // up-arrow
                            active = active ? active.previousSibling : searchBoxSuggestion.lastChild;
                        }else if(event.keyCode == 40){ // down-arrow
                            active = active ? active.nextSibling : searchBoxSuggestion.firstChild;
                        }else{}

                        if(active){
                            active.setAttribute("data-active", "1");
                            active.style.backgroundColor = "#EEEEEE";
                            active.focus();

                            searchBox.value = active.getAttribute("data-keyword");
                        }else{
                            searchBox.value = keyword;
                            searchBox.focus();
                        }

                        // To fix the cursor placement at the
                        // beginning when up arrow is pressed
                        event.preventDefault();
                    }
                </script>
            </div>

            <!-- Navbar Buttons Container -->
            <div class="col-30">
                <div class="float-right">
                    <?php
                        // Checking user exist or not
                        $USER = [];
                        if (isset($_COOKIE['token'])) {
                            $token = file_get_contents(API_ENDPOINT.'/user-token/verify/'.$_COOKIE['token']);
                            $token = json_decode($token,TRUE);

                            if(isset($token) && $token['success']){
                                $payload = file_get_contents(API_ENDPOINT.'/token/payload/'.$_COOKIE['token']);
                                $payload = json_decode($payload,TRUE);

                                if(isset($payload) && $payload['success']){   
                                    $USER = $payload['payload'];
                                }
                                unset($payload);
                            }
                            unset($token);
                        }

                        $PAGE_NAME = isset($PAGE_NAME) ? $PAGE_NAME : "";

                        if($PAGE_NAME == "Explore"){
                            echo '<a class="button padding-15 custom-text-blue bold">Explore</a>';
                        }else{
                            echo '<a href="../explore" class="button padding-15" on-hover="custom-text-blue">Explore</a>';
                        }

                        if(!$USER){
                            if($PAGE_NAME == "Login"){
                                echo '<a class="button padding-15 custom-text-blue bold">Login</a>';
                            }else{
                                echo '<a href="../login" class="button padding-15" on-hover="custom-text-blue">Login</a>';
                            }

                            if($PAGE_NAME == "Register"){
                                echo '<a class="button padding-15 custom-text-blue bold">Register</a>';
                            }else{
                                echo '<a href="../register" class="button padding-15" on-hover="custom-text-blue">Register</a>';
                            }

                        }else{
                            if($PAGE_NAME == "Profile"){
                                echo '<a href="../profile" class="button padding-15 custom-text-blue bold">'.$USER['first_name'].'</a>';
                            }else{
                                echo '<a href="../profile" class="button padding-15" on-hover="custom-text-blue">'.$USER['first_name'].'</a>';
                            }
                        }   
                    ?>
                </div>
            </div>

        </div>
    </div>
</div>