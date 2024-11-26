
var labels = [];
let detectedFaces = [];
let sendingData = false; 

function updateTable() {
    var selectedTMonthID = document.getElementById('tmonthSelect').value;
    var selectedTWeekCode = document.getElementById('tweekSelect').value;
    var selectedShift = document.getElementById("shiftSelect").value;

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'manageFolder.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.status === 'success') {
                labels = response.data;

                if (selectedTMonthID && selectedTWeekCode && selectedShift) {
                  updateOtherElements();
                }             
         document.getElementById('employeeTableContainer').innerHTML = response.html;
            } else {
                console.error('Error:', response.message);
            }
        }

    };
    xhr.send('tmonthID=' + encodeURIComponent(selectedTMonthID) +
    '&tweekID=' + encodeURIComponent(selectedTWeekCode) +
    '&shiftID=' + encodeURIComponent(selectedShift))
    
    ;
    }

    function markAttendance(detectedFaces) {
        document.querySelectorAll('#employeeTableContainer tr').forEach(row => {
            const registrationNumber = row.cells[0].innerText.trim();
            if (detectedFaces.includes(registrationNumber)) {
                row.cells[5].innerText = 'Attend';
            }
        });
    }

   

    


function updateOtherElements(){
   
const video = document.getElementById("video");
const videoContainer = document.querySelector(".video-container");
const startButton = document.getElementById("startButton");
let webcamStarted = false;
let modelsLoaded = false;


Promise.all([
  faceapi.nets.ssdMobilenetv1.loadFromUri("http://localhost/atte/Manager/models"),
  faceapi.nets.faceRecognitionNet.loadFromUri("http://localhost/atte/Manager/models"),
  faceapi.nets.faceLandmark68Net.loadFromUri("http://localhost/atte/Manager/models"),
]).then(() => {
  modelsLoaded = true;
});
startButton.addEventListener("click", async () => {
    videoContainer.style.display="flex";
  if (!webcamStarted && modelsLoaded) {
      startWebcam();
      webcamStarted = true;
  }
});




function startWebcam() {
  navigator.mediaDevices
      .getUserMedia({
          video: true,
          audio: false,
      })
      .then((stream) => {
          video.srcObject = stream;
          videoStream = stream; 
      })
      .catch((error) => {
          console.error(error);
      });

}
async function getLabeledFaceDescriptions() {
    const labeledDescriptors = [];

    for (const label of labels) {
        const descriptions = [];

        for (let i = 1; i <= 2; i++) {
            try {
                const img = await faceapi.fetchImage(`./labels/${label}/${i}.png`);
                const detections = await faceapi
                    .detectSingleFace(img)
                    .withFaceLandmarks()
                    .withFaceDescriptor();
                
                if (detections) {
                    descriptions.push(detections.descriptor);
                } else {
                    console.log(`No face detected in ${label}/${i}.png`);
                }
            } catch (error) {
                console.error(`Error processing ${label}/${i}.png:`, error);
            }
        }

        if (descriptions.length > 0) {
            detectedFaces.push(label);
            labeledDescriptors.push(new faceapi.LabeledFaceDescriptors(label, descriptions));
        }
    }

    return labeledDescriptors;
}


video.addEventListener("play", async () => {
    const labeledFaceDescriptors = await getLabeledFaceDescriptions();
    const faceMatcher = new faceapi.FaceMatcher(labeledFaceDescriptors);

    const canvas = faceapi.createCanvasFromMedia(video);
    videoContainer.appendChild(canvas);

    const displaySize = { width: video.width, height: video.height };
    faceapi.matchDimensions(canvas, displaySize);

    setInterval(async () => {
        const detections = await faceapi
            .detectAllFaces(video)
            .withFaceLandmarks()
            .withFaceDescriptors();

        const resizedDetections = faceapi.resizeResults(detections, displaySize);

        canvas.getContext("2d").clearRect(0, 0, canvas.width, canvas.height);

        const results = resizedDetections.map((d) => {
            return faceMatcher.findBestMatch(d.descriptor);
        });
        detectedFaces = results.map(result => result.label);
        markAttendance(detectedFaces);

            results.forEach((result, i) => {
            const box = resizedDetections[i].detection.box;
            const drawBox = new faceapi.draw.DrawBox(box, {
                label: result,
            });
            drawBox.draw(canvas);
        });
    }, 100);
})};



function sendAttendanceDataToServer() {
    const attendanceData = [];

    document.querySelectorAll('#employeeTableContainer tr').forEach((row, index) => {
        if (index === 0) return; 
        const employeeID = row.cells[0].innerText.trim(); 
        const tmonth = row.cells[2].innerText.trim();
        const tweek = row.cells[3].innerText.trim();
        const attendanceStatus = row.cells[5].innerText.trim(); 
        
        attendanceData.push({ employeeID,tmonth,tweek,attendanceStatus });
    });

    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'takeAttendance.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json');

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                showMessage('Attendance recorded successfully.');
            } else {
                showMessage('Error: Unable to record attendance.');
            }
        }
    };

    xhr.send(JSON.stringify(attendanceData));
}
function showMessage(message) {
    var messageDiv = document.getElementById('messageDiv');
    messageDiv.style.display="block";
    messageDiv.innerHTML = message;
    console.log(message);
    messageDiv.style.opacity = 1;
    setTimeout(function() {
      messageDiv.style.opacity = 0;
    }, 5000);
  }
function stopWebcam() {
    if (videoStream) {
        const tracks = videoStream.getTracks();

        tracks.forEach((track) => {
            track.stop();
        });

        video.srcObject = null;
        videoStream = null;
    }
}

document.getElementById("endAttendance").addEventListener("click", function() {
    sendAttendanceDataToServer();
    const videoContainer = document.querySelector(".video-container");
     videoContainer.style.display="none";
    stopWebcam();

});
