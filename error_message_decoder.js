message = "_file.jpg_fileExists_file2.exe_isNotAnImage_isTooLarge_"

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
    errExplanation = "Error:\n" + errMessages[0];
    newFile = true;
    for(let i = 1; i < errMessages.length; i++) {
        errMsg = errMessages[i];
        if(errMsg.includes(".")) {
            
            errExplanation += ".\n";
            newFile = true;
            errExplanation += errMsg;
            continue;
        }
        if(!newFile) {
            errExplanation += " and";
        }
        errExplanation += explanationDict[errMsg];
        newFile = false;
    }
    errExplanation += "."
    return errExplanation
}

console.log(messageDecoder(message));