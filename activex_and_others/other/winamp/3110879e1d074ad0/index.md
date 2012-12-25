---
Title: Взаимодействуем с WinAMP
Date: 01.01.2007
---


Взаимодействуем с WinAMP
========================

::: {.date}
01.01.2007
:::

О пользе плагинов и спорить не приходиться. Потому многие крупные
разработчики программного обеспечения предусматривают в своих творениях
поддержку модулей, написанных другими людьми. Так поступила и компания
Nullsoft, создатель известного компьютерного плеера - Winamp. Для
непосредственного обращения к плееру были созданы специальные функции -
WinampApi.

Алгоритм взаимодействия таков:

Находим Handle окна Winamp\'a. (можно так - findwindow(\'Winamp
v1.x\',nil) )

С помощью команды Sendmessage, посылаем окну сообщение вида WM\_COMMAND
или WM\_USER c определёнными параметрами (см. Приложение)

Итак, напишем, например, процедуру для проигрывания заданного трека с
заданной громкостью. В дальнейшем, её можно будет использовать в плагине
или в программе, работающей совместно с Winamp.

    procedure play_track_with_volume(track_number:integer;volume:integer);
    // Track_number - номер трека (от 1 до величины количества треков)
    // Volume - громкость (от 0 до 255)
    var
      h: hwnd;
    begin
      h:=findwindow('Winamp v1.x',g>nil); // Находим окно
      sendmessage(h,WM_USER,track_number-1,121); // Устанавливаем номер трека
      sendmessage(h,WM_USER,volume,122); // Устанавливаем громкость
      sendmessage(h,WM_COMMAND,40045,0); // Проигрываем трек
    end;

Приложение:

Параметры сообщений и их функции. (Взято с официального сайта):

WM\_COMMAND Messages

Previous track button 40044

Next track button 40048

Play button 40045

Pause/Unpause button 40046

Stop button 40047

Fadeout and stop 40147

Stop after current track 40157

Fast-forward 5 seconds 40148

Fast-rewind 5 seconds 40144

Start of playlist 40154

Go to end of playlist 40158

Open file dialog 40029

Open URL dialog 40155

Open file info box 40188

Set time display mode to elapsed 40037

Set time display mode to remaining 40038

Toggle preferences screen 40012

Open visualization options 40190

Open visualization plug-in options 40191

Execute current visualization plug-in 40192

Toggle about box 40041

Toggle title Autoscrolling 40189

Toggle always on top 40019

Toggle Windowshade 40064

Toggle Playlist Windowshade 40266

Toggle doublesize mode 40165

Toggle EQ 40036

Toggle playlist editor 40040

Toggle main window visible 40258

Toggle minibrowser 40298

Toggle easymove 40186

Raise volume by 1% 40058

Lower volume by 1% 40059

Toggle repeat 40022

Toggle shuffle 40023

Open jump to time dialog 40193

Open jump to file dialog 40194

Open skin selector 40219

Configure current visualization plug-in 40221

Reload the current skin 40291

Close Winamp 40001

Moves back 10 tracks in playlist 40197

Show the edit bookmarks 40320

Adds current track as a bookmark 40321

Play audio CD 40323

Load a preset from EQ 40253

Save a preset to EQF 40254

Opens load presets dialog 40172

Opens auto-load presets dialog 40173

Load default preset 40174

Opens save preset dialog 40175

Opens auto-load save preset 40176

Opens delete preset dialog 40178

Opens delete an auto load preset dialog 40180

WM\_USER Messages

0 Retrieves the version of Winamp running. Version will be 0x20yx for
2.yx. This is a good way to determine if you did in fact find the right
window, etc.

100 Starts playback. A lot like hitting \'play\' in Winamp, but not
exactly the same

101 Clears Winamp\'s internal playlist.

102 Begins play of selected track.

103 Makes Winamp change to the directory C:\\\\download

104 Returns the status of playback. If \'ret\' is 1, Winamp is playing.
If \'ret\' is 3, Winamp is paused. Otherwise, playback is stopped.

105 If data is 0, returns the position in milliseconds of playback. If
data is 1, returns current track length in seconds. Returns -1 if not
playing or if an error occurs.

106 Seeks within the current track. The offset is specified in \'data\',
in milliseconds.

120 Writes out the current playlist to Winampdir\\winamp.m3u, and
returns the current position in the playlist.

121 Sets the playlist position to the position specified in tracks in
\'data\'.

122 Sets the volume to \'data\', which can be between 0 (silent) and 255
(maximum).

123 Sets the panning to \'data\', which can be between 0 (all left) and
255 (all right).

124 Returns length of the current playlist, in tracks.

125 Returns the position in the current playlist, in tracks (requires
Winamp 2.05+).

126 Retrieves info about the current playing track. Returns samplerate
(i.e. 44100) if \'data\' is set to 0, bitrate if \'data\' is set to 1,
and number of channels if \'data\' is set to 2. (requires Winamp 2.05+)

127 Retrieves one element of equalizer data, based on what \'data\' is
set to. 0-9 The 10 bands of EQ data. Will return 0-63 (+20db - -20db) 10
The preamp value. Will return 0-63 (+20db - -20db) 11 Enabled. Will
return zero if disabled, nonzero if enabled.

128 Autoload. Will return zero if disabled, nonzero if enabled. To set
an element of equalizer data, simply query which item you wish to set
using the message above (127), then call this message with data

129 Adds the specified file to the Winamp bookmark list

135 Restarts Winamp

200 Sets the current skin. \'data\' points to a string that describes
what skin to load, which can either be a directory or a .zip file. If no
directory name is specified, the default Winamp skin directory is
assumed.

201 Retrieves the current skin directory and/or name. \'ret\' is a
pointer to the Skin name (or NULL if error), and if \'data\' is
non-NULL, it must point to a string 260 bytes long, which will receive
the pathname to where the skin bitmaps are stored (which can be either a
skin directory, or a temporary directory when zipped skins are used)
(Requires Winamp 2.04+).

202 Selects and executes a visualization plug-in. \'data\' points to a
string which defines which plug-in to execute. The string can be in the
following formats: vis\_whatever.dll Executes the default module in
vis\_whatever.dll in your plug-ins directory. vis\_whatever.dll,1
executes the second module in vis\_whatever.dll
C:\\path\\vis\_whatever.dll,1 executes the second module in
vis\_whatever.dll in another directory

211 Retrieves (and returns a pointer in \'ret\') a string that contains
the filename of a playlist entry (indexed by \'data\'). Returns NULL if
error, or if \'data\' is out of range.

212 Retrieves (and returns a pointer in \'ret\') a string that contains
the title of a playlist entry (indexed by \'data\'). Returns NULL if
error, or if \'data\' is out of range.

241 Opens an new URL in the minibrowser. If the URL is NULL it will open
the Minibrowser window

242 Returns 1 if the internet connecton is available for Winamp

243 Asks Winamp to update the information about the current title

245 Sets the current playlist item

246 Retrives the current Minibrowser URL into the buffer.

247 Flushes the playlist cache buffer

248 Blocks the Minibrowser from updates if value is set to 1

249 Opens an new URL in the minibrowser (like 241) except that it will
work even if 248 is set to 1

250 Returns the status of the shuffle option (1 if set)

251 Returns the status of the repeat option (1 if set)

252 Sets the status of the suffle option (1 to turn it on)

253 Sets the status of the repeat option (1 to turn it on)

Приятного Вам прослушивания музыки !!!

Взято с <https://delphiworld.narod.ru>
