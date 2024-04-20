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
    explanationDict={ 
        "fileExists":" is already in our system", 
        "isNotAnImage":" is not an image file", 
        "isTooLarge":" is too large",
        "unknownError":" incountered an unknown error :("
   };
    errExplanation = "Error:";
    for(let i = 0; i < errMessages.length; i++) {
        errMsg = errMessages[i];
        if(errMsg.includes(".")) {

            errExplanation += "\n";
            errExplanation += errMsg;
            continue;
        }
        errExplanation += explanationDict[errMsg] + ".";
    }
    return errExplanation
}



testUrl = "192.168.1.15/test.php?response=_file.jpg_fileExists_file2.exe_isNotAnImage_file2.exe_isTooLarge_"
console.log(messageDecoder(urlExtractor(testUrl)));