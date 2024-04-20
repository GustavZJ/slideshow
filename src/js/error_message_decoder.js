function urlExtractor(url) {
    startRecording = false;
    msg = "";
    for(let i = 1; i < url.length; i++) {
        letter = url[i];
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

    errMessages = [];
    errMessage = "";
    for(let i = 1; i < msg.length; i++) {

        letter = msg[i];
        if(letter == "_" && errMessage != "") {

            errMessages.push(errMessage);
            errMessage = "";
        }
        else {
            errMessage += letter;
        }
    }
    
    fileObj = {};

    for(let i = 0; i < errMessages.length; i++) {
        errMsg = errMessages[i];
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
    
    for(const [key, value] of Object.entries(fileObj)) {
            if (!errExplanation.includes(key)) {
                errExplanation += "\n" + key;
            }
            for(let i = 0; i < value.length; i++) {
                if(i > 0) {
                    errExplanation += " and"
                }
                errExplanation += explanationDict[value[i]]
            }
    }
    return errExplanation
}



//testUrl = "192.168.1.15/test.php?response=_file.jpg_fileExists_file2.exe_isNotAnImage_file2.exe_isTooLarge_"
//console.log(messageDecoder(urlExtractor(testUrl)));