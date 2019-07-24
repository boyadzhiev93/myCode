/*@ Code created for listen for change device on stream*/
window.addEventListener('Stream', function (e) {
    var event = e.detail.eventData;
    var details = GetDetails(event.extra);

     // console.log('Stream::details:', details);
     // console.log('Stream::doctorVideoContainer:', doctorVideoContainer);

    if (details.role === 'doctor') {
        initME(event, doctorVideoContainer).then(function (mediaElement) {
          //  console.log('doctor::event:', event.type);
            if (event.type === "local") {
                mediaElement.toggle(['mute-audio']);
                //alert('doctor');
                // doctorVideoContainer.addClass('pip');
            }

            doctorVideoContainer.html(mediaElement);

        }).catch(function (error) {
            console.log("error:", error.message);
        });

    } else {
        initME(event, patientVideoContainer).then(function (mediaElement) {
            //console.log('patient::event:', event.type);

            if (event.type === "local") {
                mediaElement.toggle(['mute-audio']);
                //alert('patient');
                patientVideoContainer.addClass('pip');
            }
            patientVideoContainer.html(mediaElement);

        }).catch(function (error) {
            console.log("error:", error.message);
        });
    }
});

window.addEventListener('PeerStateChanged', function (e) {
    //console.log('PeerStateChanged:', e.detail.stateData);

});

{$participant}.GetVideoDevices().then(function (cameras) {
    $.each(cameras, function () {
        var option = document.createElement('option');
        option.id = this.id;
        option.innerHTML = this.label || this.id;
        option.value = this.id;
        videoDevices.appendChild(option);
    });

}, function (error) {
    // failed
}).then(function () {
    if (sessionStorage.getItem("current_camera")) {
        var _val = sessionStorage.getItem("current_camera");
        $('#video-devices').val(_val).trigger('change');
    }

});
;

$(document).on('change', '#video-devices', function (e) {
    var _val = $(this).val();
    {$participant}.ChangeCamera(_val);
    // sessionStorage.setItem("current_camera", _val);
});


{$participant}.GetAudioDevices().then(function (cameras) {
    $.each(cameras, function () {
        var option = document.createElement('option');
        option.id = this.id;
        option.innerHTML = this.label || this.id;
        option.value = this.id;
        audioDevices.appendChild(option);
    });

}, function (error) {
    // failed
}).then(function () {
    if (sessionStorage.getItem("current_microphone")) {
        var _val = sessionStorage.getItem("current_microphone");
        $('#audio-devices').val(_val).trigger('change');
    }

});

{$participant}.GetAudioOutputDevices().then(function (cameras) {
    $.each(cameras, function () {
        var option = document.createElement('option');
        option.id = this.id;
        option.innerHTML = this.label || this.id;
        option.value = this.id;
        audioDevicesOutput.appendChild(option);
    });

}, function (error) {
    // failed
}).then(function () {
    if (sessionStorage.getItem("current_output_audio")) {
        var _val = sessionStorage.getItem("current_output_audio");
        $('#audio-devices-output').val(_val).trigger('change');
    }

});


$(document).on('change', '#audio-devices-output', function (e) {
    var _val = $(this).val();
    {$participant}.ChangeOutputAudioDevice(_val);
    // sessionStorage.setItem("current_output_audio", _val);
});


$(document).on('change', '#audio-devices', function (e) {
    var _val = $(this).val();
    {$participant}.ChangeMicrophone(_val);
    // sessionStorage.setItem("current_microphone", _val);
});
