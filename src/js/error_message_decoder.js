

function urlExtractor(url) {
    let recording = false;
    let msg = "";
    for(let i = 1; i < url.length; i++) {
        let letter = url[i];
        if(letter == "=") {
            recording = true;
            continue;
        }

        if(recording) {
            msg += letter;
        }
    }
    return msg
}


function messageDecoder(msg) {
    if(msg == "") {
        return ["no_msg", ""]
    }
    if(msg == "success") {
        return ["Success", "All files uploaded successfully"]
    }
     
    let errMessages = [];
    let errMessage = "";
    for(let i = 0; i < msg.length; i++) {

        let letter = msg[i];
        if(letter == "§" && errMessage != "") {
            console.log(errMessages)
            errMessages.push(errMessage);
            errMessage = "";
        }
        else {
            errMessage += letter;
        }
    }
    console.log(errMessages)
    let fileObj = {};
    let newestKey;

    for(let i = 0; i < errMessages.length; i++) {
        let errMsg = errMessages[i];
        if(errMsg.includes(".")) {
            if(!fileObj[errMsg]) {
                fileObj[errMsg] = [];
            };
            newestKey = errMsg
            continue;
        }
        else {
            fileObj[newestKey].push(errMsg)
            
        }
        
    }

    let errExplanation = "Error:";
    const explanationDict={ 
        "fileExists":" is already in our system", 
        "isNotAnImage":" is not an image file", 
        "isTooLarge":" is too large",
        "unknownError":" incountered an unknown error :("
   };
    let allSuccess = false;
    for(const [key, value] of Object.entries(fileObj)) {
            if (!errExplanation.includes(key)) {
                errExplanation += "<br>" + key;
            }
            for(let i = 0; i < value.length; i++) {
                if(i > 0) {
                    errExplanation += " and"
                }
                errExplanation += explanationDict[value[i]]
            }
    }
    
    
    return ["error", errExplanation]
}



// Message modal fade in / out
const messageModalColor = {'error':'white', 'success':'green'};
let fadeTimer;
let deleteTimer;

// Modal based timed message
function messageFade(type, message) {
    if(type == "no_msg") {
        return null
    }
    
    // Create modal
    const errorModal = document.createElement('div');
    errorModal.id = 'messageModalContent';
    errorModal.innerHTML = (`<div> <!-- This div is intentional -->
    <p id="statusMessage"></p>
    </div>`)

    // Append modal to HTML
    document.body.appendChild(errorModal);

    const messageModalContent = document.getElementById('messageModalContent');
    const statusMessage = document.getElementById('statusMessage');

    // Clear all timers, to prevent new timer from finishing early
    clearTimeout(fadeTimer);
    clearTimeout(deleteTimer);
    messageModalContent.style.backgroundColor = messageModalColor[type.toLowerCase()]; // Set matching color of modal
    statusMessage.innerHTML = message; // Set message
    setTimeout(() => {
        messageModalContent.style.opacity = 1; // This somehow ensure that it fades in, even when appended from JS
    }, 0);
    fadeTimer = setTimeout(() => {
        messageModalContent.style.opacity = 0; // Modal fade out
        deleteTimer = setTimeout(() => {
            errorModal.remove(); // Remove modal after fade out
        }, 250)
    }, 5000);
}




//const url = "http://192.168.1.15/index.html?response=Forest-Pixel-Lands-02-SLD-672_totallynot_the_same.jpg%D1%8DfileExists%D1%8D"
//console.log(messageDecoder(urlExtractor(testUrl)));
const url = window.location.href
messageFade(messageDecoder(urlExtractor(url))[0], messageDecoder(urlExtractor(url))[1]);