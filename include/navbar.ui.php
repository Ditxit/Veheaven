<?php

    // Including global constants
    include_once 'config.php';

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

?>

<div class="outer-container is-white sticky top custom-border-bottom">
    <div class="width-80 float-center" phone="width-100">
        <div class="row">

            <!-- Logo Container -->
            <div class="col-30" phone="col-100">
                <a href="" class="float-left" phone="-float-left width-100 text-center">
                    <!--<img src="" alt="LOGO" class="padding-15"/>-->
                    <p class="h3 bold padding-15">Veheaven</p>
                </a>
            </div>

            <!-- Search Box Container -->
            <div class="col-40 padding-top-15" phone="col-100 padding-0 padding-x-15">
                <form id="search-form" autocomplete="off" novalidate onsubmit="return false;">
                    <input id="search-box" class="radius-5 is-white-95 custom-border" type="search" name="search" placeholder="Search" inputmode="text">
                    <div id="search-suggestion" class="is-white width-100 shadow-20 radius-5" style="display:none; position:absolute; top:40; z-index:2;">
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
                    let previousSearches = new Map(); // using map as dictionary in JS

                    // Search API fetch function
                    function getSearchResult(count, keyword){
                        return fetch('<?=API_ENDPOINT.'/search'?>' + '/' + count + '/' + keyword) // url
                        .then( // On success
                            (response) => {return response.json()} // Return response json
                        ).catch( // On error
                            (error) => {return null} // Return null
                        ); // fetch complete
                    }

                    // Event to suggest the vehicle name
                    searchBox.oninput = async function(event){
                        keyword = searchBox.value;
                        let sluggifiedKeyword = slugify(keyword); 

                        searchBoxSuggestion.innerText = ""; // clear the search recommendation element

                        if(sluggifiedKeyword.length < 1){ // if no interesting text inputted
                            searchBoxSuggestion.style.display = 'none';
                            return;
                        }

                        searchBoxSuggestion.appendChild(textToNode("<p class='padding-15 text-center'>Searching ...</p>"));
                        searchBoxSuggestion.style.display = 'block';

                        let response = previousSearches.has(sluggifiedKeyword) 
                                        ? previousSearches.get(sluggifiedKeyword) 
                                        : await getSearchResult(7, sluggifiedKeyword)

                        previousSearches.set(sluggifiedKeyword, response);

                        searchBoxSuggestion.innerText = "";
                        if(!response.success || (response.content.vehicles.length < 1 && response.content.users.length < 1)) {
                            searchBoxSuggestion.appendChild(textToNode("<p class='padding-15 text-center'>No result found</p>"));
                            return;
                        }
                        
                        // Work on returned content
                        let vehicles = response.content.vehicles;
                        let users = response.content.users;

                        // For vehicles
                        for(let i = 0; i < vehicles.length; i++){

                            let id = vehicles[i].id;
                            let name = vehicles[i].name;
                            let type = vehicles[i].type.type;
                            let link = '<?=SERVER_NAME;?>/vehicle/?id=' + id;
                            let classes = i == 0 ? 'width-100 padding-y-10 padding-x-15' : 'width-100 padding-y-10 padding-x-15 custom-border-top';

                            searchBoxSuggestion.appendChild(
                                textToNode(
                                    "<a data-active='0' data-keyword='" + name + "' href='" + link + "' class='" + classes + "'>" +
                                        "<span class='float-left text-left width-80'>" + name + "</span>" +
                                        "<span class='float-right small custom-text-blue text-right width-20 padding-0' style='margin-top: 2px;'>" + type + "</span>" +
                                    "</a>"
                                )
                            );
                        } // For vehicles

                        // For users
                        for(let i = 0; i < users.length; i++){
                            let id = users[i].id;
                            let name = users[i].firstName+' '+users[i].lastName;
                            let link = '<?=SERVER_NAME;?>/profile/?id=' + id;

                            searchBoxSuggestion.appendChild(
                                textToNode(
                                    "<a data-active='0' data-keyword='" + name + "' href='" + link + "' class='width-100 padding-y-10 padding-x-15 custom-border-top'>" +
                                        "<span class='float-left text-left width-80'>" + name + "</span>" +
                                        "<span class='float-right small custom-text-blue text-right width-20 padding-0' style='margin-top: 2px;'> User </span>" +
                                    "</a>"
                                )
                            );
                        } // For users
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

            <!-- Navbar Buttons Container -- start -->
            <div class="col-30" phone="col-100">
                <div class="float-right" phone="-float-right display-block float-center">

                    <!-- For explore page -->
                    <?php if ($PAGE_NAME == "Explore") { ?>
                        <a class="button padding-15 custom-text-blue bold">Explore</a>
                    <?php } else { ?>
                        <a href="../explore" class="button padding-15" on-hover="custom-text-blue">Explore</a>
                    <?php } ?>

                    
                    <?php if (!$USER) { ?>
                        
                        <!-- For user login -->
                        <?php if ($PAGE_NAME == "Login") { ?>
                            <a class="button padding-15 custom-text-blue bold">Login</a>
                        <?php } else { ?>
                            <a href="../login" class="button padding-15" on-hover="custom-text-blue">Login</a>
                        <?php } ?>
                        
                        <!-- For user registration -->
                        <?php if ($PAGE_NAME == "Register") { ?>
                            <a class="button padding-15 custom-text-blue bold">Register</a>
                        <?php }else{ ?>
                            <a href="../register" class="button padding-15" on-hover="custom-text-blue">Register</a>
                        <?php } ?>

                    <?php } else { ?>

                        <!-- For user profile link -->
                        <?php if ($PAGE_NAME == "Profile") { ?>
                                <a href="../profile" class="button padding-15 custom-text-blue bold"><?=$USER['first_name']?></a>
                        <?php } else { ?>
                                <a href="../profile" class="button padding-15" on-hover="custom-text-blue"><?=$USER['first_name']?></a>
                        <?php } ?>

                    <?php } ?>  

                </div>
            </div>
            <!-- Navbar Buttons Container -- end -->
            
        </div>
    </div>
</div>