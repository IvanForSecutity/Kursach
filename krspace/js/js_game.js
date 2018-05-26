var current_music = GetRandomInt(0, 12);

$(document).ready(function()
{
    SetNewMusic(current_music);
});

function GetRandomInt(min, max)
{
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

function SetNewMusic(new_music)
{
    switch(new_music)
    {
    case 0:
        audio_file = "audio/Background music/Another Silence";
        break;
    case 1:
        audio_file = "audio/Background music/Awakening";
        break;
    case 2:
        audio_file = "audio/Background music/Fly 2";
        break;
    case 3:
        audio_file = "audio/Background music/Fly";
        break;
    case 4:
        audio_file = "audio/Background music/Hymn";
        break;
    case 5:
        audio_file = "audio/Background music/Running Away";
        break;
    case 6:
        audio_file = "audio/Background music/Silent Flower";
        break;
    case 7:
        audio_file = "audio/Background music/Star Flight";
        break;
    case 8:
        audio_file = "audio/Background music/Tales";
        break;
    case 9:
        audio_file = "audio/Background music/The Long Way";
        break;
    case 10:
        audio_file = "audio/Background music/Theo-Inside";
        break;
    case 11:
        audio_file = "audio/Background music/Trash";
        break;
    case 12:
        audio_file = "audio/Background music/Waiting For You";
        break;

    default:
        break;
    }

    // Change current music
    var $audio = $('#divAudio audio');
    $('#audMusicOgg').attr('src', audio_file + ".ogg");
    $('#audMusicMp3').attr('src', audio_file + ".mp3");
    $('#audMusicRef').attr('href', audio_file + ".mp3");
    $audio[0].load();
    $audio[0].play();
    
    current_music = new_music;
}

function ChangeMusic()
{
    var next_music;
    var audio_file;
    
    // Select next audio file
    do
    {
        next_music = GetRandomInt(0, 12);
    } while (next_music === current_music);

    SetNewMusic(next_music);
}

