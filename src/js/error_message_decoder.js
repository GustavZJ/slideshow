import {messageFade} from '/src/js/errorMessage.js'

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
    
     
    let errMessages = [];
    let errMessage = "";
    for(let i = 0; i < msg.length; i++) {

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
        "success":" uploaded successfully",  
        "isNotAnImage":" is not an image file", 
        "isTooLarge":" is too large",
        "unknownError":" incountered an unknown error :("
   };
    let allSuccess = true;
    for(const [key, value] of Object.entries(fileObj)) {
        if (value != "success"){
            allSuccess = false;
        }    
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
    if(allSuccess) {
        return ["Success", "All files uploaded successfully"]
    }
    
    return ["error", errExplanation]
}

//const url = "http://192.168.1.15/index.html?response=Forest-Pixel-Lands-02-SLD-672_totallynot_the_same.jpg%D1%8DfileExists%D1%8D"
//console.log(messageDecoder(urlExtractor(testUrl)));
const url = window.location.href
messageFade(messageDecoder(urlExtractor(url))[0], messageDecoder(urlExtractor(url))[1]);