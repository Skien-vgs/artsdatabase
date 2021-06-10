  
/** 
 * Database live search with Javascript fetch() and a PHP backend
 * 
 * Copyright (C) 2021 BITJUNGLE Rune Mathisen
 * This code is licensed under a GPLv3 license 
 * See http://www.gnu.org/licenses/gpl-3.0.html 
 */

/**
 * Initialisation of the app, runs once at window load
 * 
 */
 function init() {
    console.log('init()');
}

/**
 * Main search function
 * 
 * @param {string} str The search string passed to the database
 */
function search(str) {
    console.log(`search(${str})`);
    fetchSearchData(str).then((data) => {
        viewSearchResult(data);
    });
}

/**
 * Pass search string to the server and await response
 * 
 * @param {string} str The search string passed to the database
 * @returns {array} The response from the database
 */
async function fetchSearchData(str) {
    console.log(`fetchSearchData(${str})`);
    const response = await fetch('search.php', {
        method: 'POST',
        body: new URLSearchParams('str=' + str)
    });
    if (response.status != 200) {
        throw new Error(response.status);
    }
    const searchData = await response.json();
    return searchData;
}

/**
 * Generate HTML from database search response
 * 
 * @param {array} data Response from the database
 */

function viewSearchResult(data) {
    console.log(`viewSearchResult(...[${data.length}])`);
    var dataViewer = document.getElementById('dataViewerDiv');
    dataViewer.innerHTML = '';
    if (data.length > 0) {
        data.forEach(element => {
            const li = document.createElement('li');
            const a = document.createElement('a');
            a.setAttribute('href',`rike.php?id=${element['art']}`);
            a.setAttribute('class',`whitetxt`);
            a.textContent = `${element['art']} (${element['latinsk']})`;
            li.appendChild(a);
            dataViewer.appendChild(li);
            dataViewer.style.display = 'block';
            dataViewer.style.margin = '0 0 16px 16px'
        });
    }    
}


window.addEventListener('load', init);
const searchText = document.getElementById('dyr');
searchText.addEventListener('input', () => search(searchText.value));