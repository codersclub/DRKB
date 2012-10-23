<h1>Работа с печатью в TWebBrowser</h1>
<div class="date">01.01.2007</div>


<pre>
{ 
  TWebBrowser can use native IE API to print and do other things. 
  Implement on a Form a TWebBrowser component, and a button to print. 
  The code attached to this button is as follow : 
} 
 
//-------------------------------------------- 
 
procedure TForm.OnClickPrint(Sender: TObject); 
begin 
  WebBrowser.ExecWB(OLECMDID_PRINT, OLECMDEXECOPT_PROMPTUSER); 
end; 
 
//-------------------------------------------- 
</pre>
<p>You can replace "OLECMDID_PRINT" by other possibilities :</p>
<p>OLECMDID_OPEN OLECMDID_NEW OLECMDID_SAVE</p>
<p>OLECMDID_SAVEAS OLECMDID_SAVECOPYAS OLECMDID_PRINT</p>
<p>OLECMDID_PRINTPREVIEW OLECMDID_PAGESETUP OLECMDID_SPELL</p>
<p>OLECMDID_PROPERTIES OLECMDID_CUT OLECMDID_COPY</p>
<p>OLECMDID_PASTE OLECMDID_PASTESPECIAL OLECMDID_UNDO</p>
<p>OLECMDID_REDO OLECMDID_SELECTALL OLECMDID_CLEARSELECTION</p>
<p>OLECMDID_ZOOM OLECMDID_GETZOOMRANGE OLECMDID_UPDATECOMMANDS</p>
<p>OLECMDID_REFRESH OLECMDID_STOP OLECMDID_HIDETOOLBARS</p>
<p>OLECMDID_SETPROGRESSMAX OLECMDID_SETPROGRESSPOS</p>
<p>OLECMDID_SETPROGRESSTEXT</p>
<p>OLECMDID_SETTITLE OLECMDID_SETDOWNLOADSTATE OLECMDID_STOPDOWNLOAD</p>
<p>OLECMDID_FIND OLECMDID_ONTOOLBARACTIVATED OLECMDID_DELETE</p>
<p>OLECMDID_HTTPEQUIV OLECMDID_ENABLE_INTERACTION OLECMDID_HTTPEQUIV_DONE</p>
<p>OLECMDID_ONUNLOAD OLECMDID_PROPERTYBAG2 OLECMDID_PREREFRESH</p>
<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
