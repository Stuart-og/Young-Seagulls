/*AUTHOR: Dan Evans  COMPANY: Tilt  CLIENT: Brighten Up*/

//-------------------IMPORTS------------------

import mx.transitions.Tween;
//import flash.filters.BlurFilter;


//-------------------VARS------------------------

var win:Boolean;
var framesend:String;
var caught_tally_to_win:Number;
var levelruntimeseconds:Number;
var gamespeed:Number;
var timepenalty:Number;

var count:Number;
var caught_tally:Number;
var gametimeseconds:Number;
var speedvariation:Number = 10;
var currentsymbol:Number;
var catcherinitial:Number;
var scrollingcentreoffset:Number;
var bg1initial:Number;
var bg1extentleft:Number;
var bg1extentright:Number;
var symbolinitialy:Number;
var symbolinitialx:Number;
var symbolend:Number;
var symbol1speed:Number;
var symbol2speed:Number;
var symbol3speed:Number;
var symbol4speed:Number;
var symbol1current:Number;
var symbol2current:Number;
var symbol3current:Number;
var symbol4current:Number;
var symbol1move:Number;
var symbol2move:Number;
var symbol3move:Number;
var symbol4move:Number;
var rampamountL:Number = 2;
var rampamountR:Number = 2;
var ticker_tally:Number;
var ticker_speed:Number = 2;

var main_score:Number = 0;
var bonus_tally:Number;
var warning_set:Boolean;
var game_playing:Boolean;
var instructions_hit:Boolean;
var pause_hit:Boolean;
var leftdown:Boolean;
var rightdown:Boolean;

var KeyListener:Object;

// sound player
var my_sound:Sound;
var random_track:Number;
var track0_title:String = "Anafey - Hip Optimist";
var track1_title:String = "Feel Too Good (Mex Mix) - Kidda";
var track2_title:String = "Fly New Pumps - Space Raiders";
var track3_title:String = "Laser Sheep Dip Funk - Lo Fi Allstars";
var track4_title:String = "Whoosh - BRA";
var track_title:String;
var track_tally:Number = 0;
var soundtrack:Sound = new Sound();
var myArray:Array = ["0","1","2","3","4"];
var temp:Array;
var len:Number;
var ran:Number;
var i:Number;
var j:Number;
var soundon:Boolean = true;

// high scores

var hiScoreName1:String;
var hiScoreName2:String;
var hiScoreName3:String;
var hiScoreName4:String;
var hiScoreName5:String;
var hiScoreName6:String;
var hiScoreName7:String;
var hiScoreTotal1:Number;
var hiScoreTotal2:Number;
var hiScoreTotal3:Number;
var hiScoreTotal4:Number;
var hiScoreTotal5:Number;
var hiScoreTotal6:Number;
var hiScoreTotal7:Number;


//-------------------INITIALISATION---------------

hide_header_instructions();
hide_header_score();
sfx();
//get_scores();


//-------------------BUTTON FUNCTIONS---------------

function initialise_interface_buttons(){
	profile_btn.onRollOver = function(){
		this.gotoAndStop("over");
	}
	profile_btn.onRollOut = function(){
		this.gotoAndStop("normal");
	}
	profile_btn.onRelease = function(){
		profile();
	}
	
	logout_btn.onRollOver = function(){
		this.gotoAndStop("over");
	}
	logout_btn.onRollOut = function(){
		this.gotoAndStop("normal");
	}
	logout_btn.onRelease = function(){
		logout();
	}
	
	
	content_mc.pause_btn.onRollOver = function(){
		this.gotoAndStop("over");
	}
	content_mc.pause_btn.onRollOut = function(){
		this.gotoAndStop("normal");
	}
	content_mc.pause_btn.onRelease = function(){
		instructions_hit = false;
		pause_hit = true;
		pause_game();
	}
	
	content_mc.instructions_btn.onRollOver = function(){
		this.gotoAndStop("over");
	}
	content_mc.instructions_btn.onRollOut = function(){
		this.gotoAndStop("normal");
	}
	content_mc.instructions_btn.onRelease = function(){
		instructions_hit = true;
		pause_hit = false;
		unhide_instructions();
	}
	
	content_mc.start_btn.onRollOver = function() {
		this._xscale = 105;
		this._yscale = this._xscale;
	}
	content_mc.start_btn.onRollOut = function() {
		this._xscale = 100;
		this._yscale = this._xscale;
	}
	content_mc.start_btn.onRelease = function() {
		content_mc.gotoAndPlay("start");
		//trumpetSound.start(0);
	}
	
	sound_player_mc.sound_killer_btn.onRelease = function(){
			if(soundon == true){
				sound_off();
			} else {
				sound_on();
			}
	}
}

function initialise_buttons(){
	content_mc.instructions_mc.onRelease = function() {
		pause_game();
		unhide_instructions();
	}
}

function start_again_button(){
	content_mc.play_again_btn.onRollOver = function() {
		this.gotoAndStop("over");
	}
	content_mc.play_again_btn.onRollOut = function() {
		this.gotoAndStop("norm");
	}
	content_mc.play_again_btn.onRelease = function() {
		start_again();
	}
}

//-------------------FRAME LOOPS---------------

function start_frame_loop(){
	this.createEmptyMovieClip("frame_loop_mc", 10);
	frame_loop_mc.onEnterFrame = function(){
		scroll_movement();
		symbol_drop();
		catch_detection();
		collisions();
		clock();
		check_caught_tally();
		set_bonus_tally();
		catcher_ramping();
		key_control();
	}
}
function end_frame_loop(){
	unloadMovie(frame_loop_mc);
}

function loader(){
	this.createEmptyMovieClip("loader_loop_mc", 10);
	loader_loop_mc.onEnterFrame = function(){
		percentloaded = Math.floor ((100/_root.getBytesTotal()) * _root.getBytesLoaded());
		loader_mc.loaderfield_mc.text = percentloaded;
		loader_mc._xscale = percentloaded * 3;
		loader_mc._yscale = percentloaded * 3;
		loader_mc._alpha = 150 - percentloaded;
		if(percentloaded == 100){
			gotoAndStop("game");
			unloadMovie(loader_loop_mc);
		}
	}	
}

function audio_ticker_loop(){
	ticker_tally = 0;
	sound_player_mc.ticker_mc._x = 103;
	this.createEmptyMovieClip("audio_ticker_loop_mc", 12);
	audio_ticker_loop_mc.onEnterFrame = function(){
		sound_player_mc.ticker_mc._x -= ticker_speed;
		ticker_tally += ticker_speed;
		if (ticker_tally > sound_player_mc.ticker_mc._width){
			ticker_tally = 0;
			sound_player_mc.ticker_mc._x = 103;
		}
	}
}



//--------------------LISTENERS----------------------------


KeyListener = new Object();
KeyListener.onKeyDown = function():Void {
	if(Key.isDown(Key.LEFT)){
		leftdown = true;
	} 
	if(Key.isDown(Key.RIGHT)){
		rightdown = true;
	}
	if(Key.isDown(Key.RIGHT) && Key.isDown(Key.LEFT)){
		rightdown = false;
		leftdown = false;
	}
}
KeyListener.onKeyUp = function():Void {
	if(leftdown == true){
		leftdown = false;
	} else if(rightdown == true){
		rightdown = false;
	}
	//dragging=false;
}
Key.addListener(KeyListener); 

//-------------------MAIN FUNCTIONS---------------


function initialise_level1(){
	win=false;
	framesend="welldone1";
	caught_tally_to_win=6;
	levelruntimeseconds=120;
	gamespeed=2;
	timepenalty=5;
	initialise_game();
	pause_game();
	game_playing = false;
	unhide_instructions();
	content_mc.instructions_mc.gully_mc.gotoAndStop(1);
	game_playing = true;
}
function initialise_level2(){
	tickingSound.stop();
	framesend="welldone2";
	caught_tally_to_win=7;
	levelruntimeseconds=90;
	gamespeed=4;
	timepenalty=7;
	initialise_game();
}
function initialise_level3(){
	tickingSound.stop();
	framesend="gameend";
	caught_tally_to_win=8;
	levelruntimeseconds=60;
	gamespeed=6;
	timepenalty=8;
	initialise_game();
}

function initialise_game(){
	warning_set = true;
	reset_score_time();
	currentsymbol=random(5)+1;
	content_mc.objectname_mc.gotoAndStop(currentsymbol);
	get_initial_placements();
	symbol1_reset();
	symbol2_reset();
	symbol3_reset();
	symbol4_reset();
	initialise_buttons();
	start_frame_loop();
	enable_instructions_button();
	enable_pause_button();
}

function get_initial_placements(){
	symbolinitialy=content_mc.bg1_mc.symbol1_mc._y;
	symbolinitialx=content_mc.bg1_mc.symbol1_mc._x;
	catcherinitial=content_mc.catcher_mc._x;
	scrollingcentreoffset=58;
	bg1initial=content_mc.bg1_mc._x;
	bg1extentleft=-52;
	bg1extentright=170;
	symbolend=content_mc.bg1_mc.symbol1_mc._y+550;
}

function symbol1_reset(){
	symbol1speed=random(speedvariation)+gamespeed;
	symbol1current=random(5)+1;
	content_mc.bg1_mc.symbol1_mc.symbolselect_mc.gotoAndStop(symbol1current);
	symbol1move=random(520);
	content_mc.bg1_mc.symbol1_mc._x=symbolinitialx;
	content_mc.bg1_mc.symbol1_mc._x+=symbol1move;
	content_mc.bg1_mc.symbol1_mc._y = symbolinitialy;
}
function symbol2_reset(){
	symbol2speed=random(speedvariation)+gamespeed;
	symbol2current=random(5)+1;
	content_mc.bg1_mc.symbol2_mc.symbolselect_mc.gotoAndStop(symbol2current);
	symbol2move=random(520);
	content_mc.bg1_mc.symbol2_mc._x=symbolinitialx;
	content_mc.bg1_mc.symbol2_mc._x+=symbol2move;
	content_mc.bg1_mc.symbol2_mc._y = symbolinitialy;
}
function symbol3_reset(){
	symbol3speed=random(speedvariation)+gamespeed;
	symbol3current=random(5)+1;
	content_mc.bg1_mc.symbol3_mc.symbolselect_mc.gotoAndStop(symbol3current);
	symbol3move=random(520);
	content_mc.bg1_mc.symbol3_mc._x=symbolinitialx;
	content_mc.bg1_mc.symbol3_mc._x+=symbol3move;
	content_mc.bg1_mc.symbol3_mc._y = symbolinitialy;
}
function symbol4_reset(){
	symbol4speed=random(speedvariation)+gamespeed;
	symbol4current=random(5)+1;
	content_mc.bg1_mc.symbol4_mc.symbolselect_mc.gotoAndStop(symbol4current);
	symbol4move=random(520);
	content_mc.bg1_mc.symbol4_mc._x=symbolinitialx;
	content_mc.bg1_mc.symbol4_mc._x+=symbol4move;
	content_mc.bg1_mc.symbol4_mc._y = symbolinitialy;
}

function reset_score_time(){
	count=0;
	caught_tally=0;
	gametimeseconds=0;
	bonus_tally = 1000;
}


function scroll_movement(){
	content_mc.bg1_mc._x = ((content_mc.catcher_mc._x-content_mc.catcher_mc._x-content_mc.catcher_mc._x) + 140)/1.25;
}

function symbol_drop(){
	content_mc.bg1_mc.symbol1_mc._y+=symbol1speed;
	content_mc.bg1_mc.symbol2_mc._y+=symbol2speed;
	content_mc.bg1_mc.symbol3_mc._y+=symbol3speed;
	content_mc.bg1_mc.symbol4_mc._y+=symbol4speed;
	if(content_mc.bg1_mc.symbol1_mc._y > symbolend){
		symbol1_reset();		
	}
	if(content_mc.bg1_mc.symbol2_mc._y > symbolend){
		symbol2_reset();
	}
	if(content_mc.bg1_mc.symbol3_mc._y > symbolend){
		symbol3_reset();
	}
	if(content_mc.bg1_mc.symbol4_mc._y > symbolend){
		symbol4_reset();
	}
}

function catch_detection(){
	sym1collision = content_mc.bg1_mc.symbol1_mc.hitTest(content_mc.catcher_mc.hitarea_mc);
	sym2collision = content_mc.bg1_mc.symbol2_mc.hitTest(content_mc.catcher_mc.hitarea_mc);
	sym3collision = content_mc.bg1_mc.symbol3_mc.hitTest(content_mc.catcher_mc.hitarea_mc);
	sym4collision = content_mc.bg1_mc.symbol4_mc.hitTest(content_mc.catcher_mc.hitarea_mc);
	if(sym1collision == true){
		trace("1 = "+sym1collision);
	}
	if(sym2collision == true){
		trace("2 = "+sym2collision);
	}
	if(sym3collision == true){
		trace("3 = "+sym3collision);
	}
	if(sym4collision == true){
		trace("4 = "+sym4collision);
	}
}

function collisions(){
	if(sym1collision==true || sym2collision==true || sym3collision==true || sym4collision==true){
		catchSound.start(0);
		if(sym1collision==true && symbol1current==currentsymbol){
			symbol1_reset();
			correct_catch();
		}
		if(sym2collision==true && symbol2current==currentsymbol){
			symbol2_reset();
			correct_catch();
		}
		if(sym3collision==true && symbol3current==currentsymbol){
			symbol3_reset();
			correct_catch();
		}
		if(sym4collision==true && symbol4current==currentsymbol){
			symbol4_reset();
			correct_catch();
		}
		//wrong symbol
		if(sym1collision==true && symbol1current!=currentsymbol){
			symbol1_reset();
			incorrect_catch();
		}
		if(sym2collision==true && symbol2current!=currentsymbol){
			symbol2_reset();
			incorrect_catch();
		}
		if(sym3collision==true && symbol3current!=currentsymbol){
			symbol3_reset();
			incorrect_catch();
		}
		if(sym4collision==true && symbol4current!=currentsymbol){
			symbol4_reset();
			incorrect_catch();
		}
	}
}

function correct_catch(){
	trace("correct");
	gametimeseconds-=timepenalty;
	content_mc.catcher_mc.splat.gotoAndPlay("start");
	caught_tally+=1;
	currentsymbol=random(5)+1;
	content_mc.catcher_mc.currentsymbol_mc.play();
	content_mc.scoreflash_mc.gotoAndPlay("start");
	content_mc.objectname_mc.gotoAndStop(currentsymbol);
	set_score();
}

function incorrect_catch(){
	trace("incorrect");
	gametimeseconds+=timepenalty;
	content_mc.catcher_mc.play();
	content_mc.timepenalty_mc.gotoAndPlay("start");
	bonus_tally -= 100 + random (100);
}


function clock(){
	count+=1;
	if(count>25){
		gametimeseconds+=1;
		count=0;
	}
	content_mc.timer_mc.gotoAndStop(Math.floor(100/levelruntimeseconds*gametimeseconds));
	if(gametimeseconds>((levelruntimeseconds/100)*90) && warning_set == true){
		content_mc.timer_mc.warning_mc.gotoAndPlay("loop");
		warning_set = false;
		tickingSound.start(0,99);
	}
	if(gametimeseconds>levelruntimeseconds){
		end_frame_loop();
		game_lose();
		tickingSound.stop();
		loseSound.start(0);
	}
}

function check_zeros(){
	if(main_score > 9){
		mainscore_mc.zero1_mc._visible = false;
	}
	if(main_score > 99){
		mainscore_mc.zero2_mc._visible = false;
	}
	if(main_score > 999){
		mainscore_mc.zero3_mc._visible = false;
	}
	if(main_score > 9999){
		mainscore_mc.zero4_mc._visible = false;
	}
	if(main_score > 99999){
		mainscore_mc.zero5_mc._visible = false;
	}
}

function reset_zeros(){
	mainscore_mc.zero1_mc._visible = true;
	mainscore_mc.zero2_mc._visible = true;
	mainscore_mc.zero3_mc._visible = true;
	mainscore_mc.zero4_mc._visible = true;
	mainscore_mc.zero5_mc._visible = true;
	mainscore_mc.zero6_mc._visible = true;
	mainscore_mc.zero7_mc._visible = true;
	mainscore_mc.zero8_mc._visible = true;
	mainscore_mc.zero9_mc._visible = true;
	mainscore_mc.zero10_mc._visible = true;
}

function check_caught_tally(){
	content_mc.score_mc.gotoAndStop(Math.floor(100/caught_tally_to_win*caught_tally));
	//end game
	if(caught_tally>caught_tally_to_win-1){
			content_mc.catcher_mc.splat.gotoAndPlay("start");
			content_mc.gotoAndPlay(framesend);
			end_frame_loop();
	}
}

function set_bonus_tally(){
	bonus_tally--;
}

function set_score(){
	main_score += 1000;
	if(bonus_tally > 0){
		main_score += bonus_tally;
	}
	mainscore_mc.scoretotal_mc.text = main_score;
	bonus_tally = 1000;
	check_zeros();
}

function hide_header_score(){
	mainscore_mc._visible = false;
}
function unhide_header_score(){
	mainscore_mc._visible = true;
}
function hide_header_instructions(){
	instructions_header_mc._visible = false;
}
function unhide_header_instructions(){
	instructions_header_mc._visible = true;
}

function game_win(){
	trace("winwinwinwinwinwinwinwinwinwinwinwinwinwinwinwinwinwinwinwinwinwinwinwinwinwinwinwinwinwinwinwinwinwin");
	squawkWinSound.start(0,4);
	disable_instructions_button();
	disable_pause_button();
	win=true;
	gotoAndPlay("game_end");
	content_mc.timer_mc._visible = false;
	send_scores();
}
function game_lose(){
	loseSound.start(0);
	disable_instructions_button();
	disable_pause_button();
	win=false;
	gotoAndPlay("game_end");
	content_mc.timer_mc._visible = false;
	send_scores();
}

function win_decision(){
	trace ("decision="+win);
	if(win==true){
		gotoAndStop("winscreen");
	}else{
		gotoAndStop("losescreen");
	}
}

function pause_game(){
	content_mc.pause_txt.play();
	content_mc.pause_txt_dummy.play();
	if (game_playing == true){
		pause_play();
		disable_instructions_button();
	} else {
		unpause_play();
		enable_instructions_button()
	}
}

function unhide_instructions(){
	content_mc.instruction_txt.play();
	content_mc.instruction_txt_dummy.play();
	content_mc.pause_txt.play();
	content_mc.pause_txt_dummy.play();
	if (game_playing == true){
		pause_play();
		content_mc.instructions_mc._visible = true;
		new mx.transitions.Tween(content_mc.instructions_mc, "_alpha", mx.transitions.easing.Strong.easeOut,0,100,1,true);
		hide_header_score();
		unhide_header_instructions();
		disable_pause_button();
		content_mc.instructions_mc.gully_mc.gotoAndPlay(1);
	} else {
		unpause_play();
		content_mc.instructions_mc._visible = false;
		unhide_header_score();
		hide_header_instructions();
		enable_pause_button();
		content_mc.instructions_mc.gully_mc.gotoAndStop(1);
	}
}


function pause_play(){
	end_frame_loop();
	//dragging=false;
	content_mc.catcher_mc.stopDrag();
	new mx.transitions.Tween(content_mc.catcher_mc, "_x", mx.transitions.easing.Bounce.easeOut,content_mc.catcher_mc._x,catcherinitial,0.5,true);
	new mx.transitions.Tween(content_mc.bg1_mc, "_x", mx.transitions.easing.Strong.easeOut,content_mc.bg1_mc._x,bg1initial,0.5,true);
}
function unpause_play(){
	start_frame_loop();
}

function disable_pause_button(){
	content_mc.pause_txt._visible = false;
	content_mc.pause_btn._visible = false;
}
function enable_pause_button(){
	content_mc.pause_txt._visible = true;
	content_mc.pause_btn._visible = true;
}
function disable_instructions_button(){
	content_mc.instruction_txt._visible = false;
	content_mc.instructions_btn._visible = false;
}
function enable_instructions_button(){
	content_mc.instruction_txt._visible = true;
	content_mc.instructions_btn._visible = true;
}


function start_again(){
	main_score = 0;
	mainscore_mc.scoretotal_mc.text = main_score;
	reset_zeros();
	hide_header_instructions();
	hide_header_score();
	gotoAndStop("game");
	content_mc.timer_mc._visible = true;
}

function play_ball_trans(){
	trace("ball trans");
	ball_transition_mc.gotoAndPlay("start");
}

function key_control(){
		
}

function catcher_ramping(){
	if(/*leftdown == true && */rampamountL > 1 && content_mc.catcher_mc._x > -100){
		content_mc.catcher_mc._x -= 0 + rampamountL;
		//dragging=true;
	} 
	if(/*rightdown == true && */rampamountR > 1 && content_mc.catcher_mc._x < 250){
		content_mc.catcher_mc._x += 0 + rampamountR;
		//dragging=true;
	}

	
	if(leftdown == true && rampamountL < 15){
		rampamountL *= 1.6;
	}
	if(leftdown == false && rampamountL > 1){
		rampamountL /= 2;
	}
	if(rightdown == true && rampamountR < 15){
		rampamountR *= 1.6;
	}
	if(rightdown == false && rampamountR > 1){
		rampamountR /= 2;
	}
	//trace("R = "+rampamountR);
}


////////////////////////////////SOUND//////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////


Array.prototype.Random = function() {
	len = this.length;
	temp = new Array();
		for (i=0; i<len; i++) {
		ran = Math.round(Math.random() * (this.length - 1));
		temp[i] = this[ran];
		this.splice(ran, 1);
	}	
	for (j=0; j<len; j++){
		this[j] = temp[j];
	}
}
myArray.Random();

function track_loader(){
	trace(myArray);
	if (track_tally > (len-1)){
		track_tally = 0;
	}
	randomtrack = _root["track"+myArray[track_tally]+"_title"]
	trace(randomtrack);
	sound_player_mc.ticker_mc.track_name_mc.text = randomtrack;
	track_tally ++;
	soundtrack.loadSound("/fileadmin/templates/swf/tunes/"+randomtrack+".mp3", true);
	soundtrack.onSoundComplete = function() {
		trace(randomtrack+" is finished");
		track_loader();
	}
	if(soundon == true){
		soundtrack.setVolume(60);
	} else {
		soundtrack.setVolume(0);
	}
	
}

function sound_off(){
	soundon = false;
	sound_player_mc.sound_killer_btn.symbol_mc.soundwaves_mc._visible = false;
	soundtrack.setVolume(0);
}
function sound_on(){
	soundon = true;
	sound_player_mc.sound_killer_btn.symbol_mc.soundwaves_mc._visible = true;
	soundtrack.setVolume(60);
}

function sfx(){
	winSound = new Sound(this);
	winSound.attachSound("hooray.mp3");
	loseSound = new Sound(this);
	loseSound.attachSound("catch_lose.wav");
	trumpetSound = new Sound(this);
	trumpetSound.attachSound("airhornhorn.wav");
	catchSound = new Sound(this);
	catchSound.attachSound("bong1.mp3");
	squawkWinSound = new Sound(this);
	squawkWinSound.attachSound("parrot2.mp3");
	squawkLoseSound = new Sound(this);
	squawkLoseSound.attachSound("parrot3.mp3");
	tickingSound = new Sound(this);
	tickingSound.attachSound("ticker.mp3");
	alarmSound = new Sound(this);
	alarmSound.attachSound("endalarm.mp3");
	//tickingSound.start(0,10);
}

////////////////////////////////SCORE TABLE////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////

function initial_scores(){
	hiScoreName1 = "Gully";
	hiScoreName2 = "Steve Foster";
	hiScoreName3 = "Mark Lawrenson";
	hiScoreName4 = "Andy Ritchie";
	hiScoreName5 = "Howard Wilkinson";
	hiScoreName6 = "E.S. Breezy";
	hiScoreName7 = "Barney Barnacle";
	hiScoreTotal1 = 14000;
	hiScoreTotal2 = 12000;
	hiScoreTotal3 = 10000;
	hiScoreTotal4 = 8000;
	hiScoreTotal5 = 6000;
	hiScoreTotal6 = 4000;
	hiScoreTotal7 = 2000;
}

function populate_scores(){
	//trace("name1= "+hiScoreName1);
	scoreboard_mc.name1.text = hiScoreName1;
	scoreboard_mc.name2.text = hiScoreName2;
	scoreboard_mc.name3.text = hiScoreName3; 
	scoreboard_mc.name4.text = hiScoreName4;
	scoreboard_mc.name5.text = hiScoreName5;
	scoreboard_mc.name6.text = hiScoreName6;
	scoreboard_mc.name7.text = hiScoreName7;
	scoreboard_mc.score1.text = hiScoreTotal1;
	scoreboard_mc.score2.text = hiScoreTotal2;
	scoreboard_mc.score3.text = hiScoreTotal3;
	scoreboard_mc.score4.text = hiScoreTotal4; 
	scoreboard_mc.score5.text = hiScoreTotal5; 
	scoreboard_mc.score6.text = hiScoreTotal6; 
	scoreboard_mc.score7.text = hiScoreTotal7;
}

function get_scores(){
	loadVariablesNum ("myGetScript.php", 0, "GET");
}

function send_scores(){
	var sendInfo = new LoadVars();
	sendInfo.username = username;
	sendInfo.userscore = mainscore_mc.scoretotal_mc.text;
	sendInfo.send("mySendScript.php", "_self","POST");
	trace(sendInfo);
}

////////////////////////////////OTHER BUTTONS///////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////

function logout(){
	/*logout script to go here*/
}
function profile(){
	/*profile script to go here*/
}

