import {messageFade} from "/src/js/popup.js";

function urlExtractor(url) {
    let startRecording = false;
    let msg = "";
    for(let i = 1; i < url.length; i++) {
        let letter = url[i];
        if(letter == "=") {
            startRecording = true;
            continue;
        }

        if(startRecording) {
            msg += letter;
        }
    }
    return msg
}


function messageDecoder(msg) {
    if(msg == "success") {
        return ["Success", "All files uploaded successfully"]
    }
     
    let errMessages = [];
    let errMessage = "";
    for(let i = 1; i < msg.length; i++) {

        let letter = msg[i];
        if(letter == "_" && errMessage != "") {

            errMessages.push(errMessage);
            errMessage = "";
        }
        else {
            errMessage += letter;
        }
    }
    
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



//const testUrl = "192.168.1.15/test.php?response=success"
//console.log(messageDecoder(urlExtractor(testUrl)));
const url = window.location.href
messageFade(messageDecoder(urlExtractor(url))[0], messageDecoder(urlExtractor(url))[1]);