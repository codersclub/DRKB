<h1>Взаимодействуем с WinAMP</h1>
<div class="date">01.01.2007</div>


<p>О пользе плагинов и спорить не приходиться. Потому многие крупные разработчики программного обеспечения предусматривают в своих творениях поддержку модулей, написанных другими людьми. Так поступила и компания Nullsoft, создатель известного компьютерного плеера - Winamp. Для непосредственного обращения к плееру были созданы специальные функции - WinampApi.</p>

<p>Алгоритм взаимодействия таков:</p>

<p>Находим Handle окна Winamp'a. (можно так - findwindow('Winamp v1.x',nil) )</p>
<p>С помощью команды Sendmessage, посылаем окну сообщение вида WM_COMMAND или WM_USER c определёнными параметрами (см. Приложение)</p>
<p>Итак, напишем, например, процедуру для проигрывания заданного трека с заданной громкостью. В дальнейшем, её можно будет использовать в плагине или в программе, работающей совместно с Winamp.</p>
<pre>
procedure play_track_with_volume(track_number:integer;volume:integer);
// Track_number - номер трека (от 1 до величины количества треков)
// Volume - громкость (от 0 до 255)
var
  h: hwnd;
begin
  h:=findwindow('Winamp v1.x',g&gt;nil); // Находим окно
  sendmessage(h,WM_USER,track_number-1,121); // Устанавливаем номер трека
  sendmessage(h,WM_USER,volume,122); // Устанавливаем громкость
  sendmessage(h,WM_COMMAND,40045,0); // Проигрываем трек
end;
</pre>



<p>Приложение:</p>

<p>Параметры сообщений и их функции. (Взято с официального сайта):</p>

<p>WM_COMMAND Messages</p>

<p>Previous track button 40044</p>
<p>Next track button 40048</p>
<p>Play button 40045</p>
<p>Pause/Unpause button 40046</p>
<p>Stop button 40047</p>
<p>Fadeout and stop 40147</p>
<p>Stop after current track 40157</p>
<p>Fast-forward 5 seconds 40148</p>
<p>Fast-rewind 5 seconds 40144</p>
<p>Start of playlist 40154</p>
<p>Go to end of playlist 40158</p>
<p>Open file dialog 40029</p>
<p>Open URL dialog 40155</p>
<p>Open file info box 40188</p>
<p>Set time display mode to elapsed 40037</p>
<p>Set time display mode to remaining 40038</p>
<p>Toggle preferences screen 40012</p>
<p>Open visualization options 40190</p>
<p>Open visualization plug-in options 40191</p>
<p>Execute current visualization plug-in 40192</p>
<p>Toggle about box 40041</p>
<p>Toggle title Autoscrolling 40189</p>
<p>Toggle always on top 40019</p>
<p>Toggle Windowshade 40064</p>
<p>Toggle Playlist Windowshade 40266</p>
<p>Toggle doublesize mode 40165</p>
<p>Toggle EQ 40036</p>
<p>Toggle playlist editor 40040</p>
<p>Toggle main window visible 40258</p>
<p>Toggle minibrowser 40298</p>
<p>Toggle easymove 40186</p>
<p>Raise volume by 1% 40058</p>
<p>Lower volume by 1% 40059</p>
<p>Toggle repeat 40022</p>
<p>Toggle shuffle 40023</p>
<p>Open jump to time dialog 40193</p>
<p>Open jump to file dialog 40194</p>
<p>Open skin selector 40219</p>
<p>Configure current visualization plug-in 40221</p>
<p>Reload the current skin 40291</p>
<p>Close Winamp 40001</p>
<p>Moves back 10 tracks in playlist 40197</p>
<p>Show the edit bookmarks 40320</p>
<p>Adds current track as a bookmark 40321</p>
<p>Play audio CD 40323</p>
<p>Load a preset from EQ 40253</p>
<p>Save a preset to EQF 40254</p>
<p>Opens load presets dialog 40172</p>
<p>Opens auto-load presets dialog 40173</p>
<p>Load default preset 40174</p>
<p>Opens save preset dialog 40175</p>
<p>Opens auto-load save preset 40176</p>
<p>Opens delete preset dialog 40178</p>
<p>Opens delete an auto load preset dialog 40180</p>

<p>WM_USER Messages</p>

<p>0 Retrieves the version of Winamp running. Version will be 0x20yx for 2.yx. This is a good way to determine if you did in fact find the right window, etc.</p>
<p>100 Starts playback. A lot like hitting 'play' in Winamp, but not exactly the same</p>
<p>101 Clears Winamp's internal playlist.</p>
<p>102 Begins play of selected track.</p>
<p>103 Makes Winamp change to the directory C:\\download</p>
<p>104 Returns the status of playback. If 'ret' is 1, Winamp is playing. If 'ret' is 3, Winamp is paused. Otherwise, playback is stopped.</p>
<p>105 If data is 0, returns the position in milliseconds of playback. If data is 1, returns current track length in seconds. Returns -1 if not playing or if an error occurs.</p>
<p>106 Seeks within the current track. The offset is specified in 'data', in milliseconds.</p>
<p>120 Writes out the current playlist to Winampdir\winamp.m3u, and returns the current position in the playlist.</p>
<p>121 Sets the playlist position to the position specified in tracks in 'data'.</p>
<p>122 Sets the volume to 'data', which can be between 0 (silent) and 255 (maximum).</p>
<p>123 Sets the panning to 'data', which can be between 0 (all left) and 255 (all right).</p>
<p>124 Returns length of the current playlist, in tracks.</p>
<p>125 Returns the position in the current playlist, in tracks (requires Winamp 2.05+).</p>
<p>126 Retrieves info about the current playing track. Returns samplerate (i.e. 44100) if 'data' is set to 0, bitrate if 'data' is set to 1, and number of channels if 'data' is set to 2. (requires Winamp 2.05+)</p>
<p>127 Retrieves one element of equalizer data, based on what 'data' is set to. 0-9 The 10 bands of EQ data. Will return 0-63 (+20db - -20db) 10 The preamp value. Will return 0-63 (+20db - -20db) 11 Enabled. Will return zero if disabled, nonzero if enabled.</p>
<p>128 Autoload. Will return zero if disabled, nonzero if enabled. To set an element of equalizer data, simply query which item you wish to set using the message above (127), then call this message with data</p>
<p>129 Adds the specified file to the Winamp bookmark list</p>
<p>135 Restarts Winamp</p>
<p>200 Sets the current skin. 'data' points to a string that describes what skin to load, which can either be a directory or a .zip file. If no directory name is specified, the default Winamp skin directory is assumed.</p>
<p>201 Retrieves the current skin directory and/or name. 'ret' is a pointer to the Skin name (or NULL if error), and if 'data' is non-NULL, it must point to a string 260 bytes long, which will receive the pathname to where the skin bitmaps are stored (which can be either a skin directory, or a temporary directory when zipped skins are used) (Requires Winamp 2.04+).</p>
<p>202 Selects and executes a visualization plug-in. 'data' points to a string which defines which plug-in to execute. The string can be in the following formats: vis_whatever.dll Executes the default module in vis_whatever.dll in your plug-ins directory. vis_whatever.dll,1 executes the second module in vis_whatever.dll C:\path\vis_whatever.dll,1 executes the second module in vis_whatever.dll in another directory</p>
<p>211 Retrieves (and returns a pointer in 'ret') a string that contains the filename of a playlist entry (indexed by 'data'). Returns NULL if error, or if 'data' is out of range.</p>
<p>212 Retrieves (and returns a pointer in 'ret') a string that contains the title of a playlist entry (indexed by 'data'). Returns NULL if error, or if 'data' is out of range.</p>
<p>241 Opens an new URL in the minibrowser. If the URL is NULL it will open the Minibrowser window</p>
<p>242 Returns 1 if the internet connecton is available for Winamp</p>
<p>243 Asks Winamp to update the information about the current title</p>
<p>245 Sets the current playlist item</p>
<p>246 Retrives the current Minibrowser URL into the buffer.</p>
<p>247 Flushes the playlist cache buffer</p>
<p>248 Blocks the Minibrowser from updates if value is set to 1</p>
<p>249 Opens an new URL in the minibrowser (like 241) except that it will work even if 248 is set to 1</p>
<p>250 Returns the status of the shuffle option (1 if set)</p>
<p>251 Returns the status of the repeat option (1 if set)</p>
<p>252 Sets the status of the suffle option (1 to turn it on)</p>
<p>253 Sets the status of the repeat option (1 to turn it on)</p>

<p>Приятного Вам прослушивания музыки !!!</p>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
