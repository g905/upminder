var player = new Playerjs({
	id:"player", 
	file:"{Английский}rick_and_morty_EU.mp4;{Русский}Рик_и_Морти_1_сезон_-_1_серия.mp4",
	subtitle:"[Английский]ram.en.srt,[Русский]Rick.and.Morty.S01E01.HDRip.rus.srt",
	ratio:"16/9",title:"Рик и Морти",lang:"ru",
});

/* Массив со словами */
var words = [];

var player_playing = false;
var player_fullscreen = false;
function PlayerjsSubtitle(event){
   event.stopPropagation() = true;
   var word = event.target.innerHTML;
   var type = event.type;
   if(word && type){
      player_fullscreen = player.api("isfullscreen");
      if(type=="onclick"){
         word = word.replace(/[.:,s]/g, "");
         player_playing = player.api("playing");
         if(player_playing){
            player.api("pause");
         }
         player.api("box","playerjs_subtitle_box");
         $("#playerjs_subtitle_box").html(Translate(word));
         var left = (event.pageX + (!player_fullscreen?window.scrollX - $("#player").offset().left:0)+10)+"px";
         var top = (event.pageY + (!player_fullscreen?window.scrollY - $("#player").offset().top:0)+10)+"px";
         $("#playerjs_subtitle_box").css({"left":left, "top":top});
      }
      if(type=="onclick"){
         if(player_playing){
            player.api("play");
         }
         $("#playerjs_subtitle_box").remove();
      }
   }
}

function Translate(word){

}
function Rewind(){
   let currentTime = player.api("time");
   let newTime = currentTime - 10;

   if(player.api("audiotrack") == "Русский"){   
      player.api("audiotrack",0);    
      player.api("seek",newTime);               
  }else{
   player.api("audiotrack",1);
   player.api("seek",newTime);     
   }

   setTimeout(()=>{     
      if(player.api("audiotrack") == "Русский"){                
         player.api("audiotrack",0);                  
     }else{
         player.api("audiotrack",1);
      }    
   },10000)  
  }
  
  function SwapAudio(){
   let currentTime = player.api("time");
   if(player.api("audiotrack") == "Русский"){   
      player.api("audiotrack",0);    
      player.api("seek",currentTime);          
      
  }else{
      player.api("audiotrack",1);
      player.api("seek",currentTime);     
      }
  }
  
var pTime = 0;
var opTime = 0;
var pWords = [];
var pTimes = [];
  
function PlayerjsEvents(event, id, info){
	
	//console.log(event);
	
	if (event == 'play') {
	
		console.log('Play');
		
		console.log($('pjsdiv').first().html());
		
		if ($('#words.words')) {
			$('#oframeplayer').find('pjsdiv').first().prepend('<div id="words" class="words" style="font-size: 20px; line-height: 24px; text-align: left; position: absolute; top: 0; left: 0; padding: 15px;"></div>');
		}
	
	}
	
	if (event == 'pause') {
		
		console.log('Pause');
		console.log(pWords);
		console.log(pTimes);
		
	}
	
	if (event == 'time') {
		pTime = info;
	}
	
    if (event == "sub") {
       
		var res = info.match(/>(.*?)<\/span>/g).map(function(val) {
			
			val = val.replace('>', '');
			val = val.replace('</span>', '');

			//console.log(val);
			pWords.push(val);
			pTimes.push(pTime);
				
			var fpTime = Math.floor(pTime);
			
			if (fpTime > opTime) {
				
				console.log(fpTime + '-' + opTime);
				$('.min_' + opTime).remove();
				opTime++;
						
			}
			
			$('#words').append('<div class="pjs_min min_' + fpTime + '">' + val + ' - <span style="color: yellow;">перевод</span></div>');
						
		});
	   
    }
	
 }
function AddInDictionary(event,id,info){
   let dictionary = [];
      // for(let i = 0;i < dictionary.length;i++){
      //    dictionary[i] += info;
      //    console.log(dictionary);
      // }
   
}
