---
Title: Работа с печатью в TWebBrowser
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Работа с печатью в TWebBrowser
==============================

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

You can replace "OLECMDID\_PRINT" by other possibilities:

- OLECMDID_OPEN
- OLECMDID_NEW
- OLECMDID_SAVE
- OLECMDID_SAVEAS
- OLECMDID_SAVECOPYAS
- OLECMDID_PRINT
- OLECMDID_PRINTPREVIEW
- OLECMDID_PAGESETUP
- OLECMDID_SPELL
- OLECMDID_PROPERTIES
- OLECMDID_CUT
- OLECMDID_COPY
- OLECMDID_PASTE
- OLECMDID_PASTESPECIAL
- OLECMDID_UNDO
- OLECMDID_REDO
- OLECMDID_SELECTALL
- OLECMDID_CLEARSELECTION
- OLECMDID_ZOOM
- OLECMDID_GETZOOMRANGE
- OLECMDID_UPDATECOMMANDS
- OLECMDID_REFRESH
- OLECMDID_STOP
- OLECMDID_HIDETOOLBARS
- OLECMDID_SETPROGRESSMAX
- OLECMDID_SETPROGRESSPOS
- OLECMDID_SETPROGRESSTEXT
- OLECMDID_SETTITLE
- OLECMDID_SETDOWNLOADSTATE
- OLECMDID_STOPDOWNLOAD
- OLECMDID_FIND
- OLECMDID_ONTOOLBARACTIVATED
- OLECMDID_DELETE
- OLECMDID_HTTPEQUIV
- OLECMDID_ENABLE_INTERACTION
- OLECMDID_HTTPEQUIV_DONE
- OLECMDID_ONUNLOAD
- OLECMDID_PROPERTYBAG2
- OLECMDID_PREREFRESH

