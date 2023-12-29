---
Title: Работа с печатью в TWebBrowser
Date: 01.01.2007
---


Работа с печатью в TWebBrowser
==============================

::: {.date}
01.01.2007
:::

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

You can replace "OLECMDID\_PRINT" by other possibilities :

OLECMDID\_OPEN OLECMDID\_NEW OLECMDID\_SAVE

OLECMDID\_SAVEAS OLECMDID\_SAVECOPYAS OLECMDID\_PRINT

OLECMDID\_PRINTPREVIEW OLECMDID\_PAGESETUP OLECMDID\_SPELL

OLECMDID\_PROPERTIES OLECMDID\_CUT OLECMDID\_COPY

OLECMDID\_PASTE OLECMDID\_PASTESPECIAL OLECMDID\_UNDO

OLECMDID\_REDO OLECMDID\_SELECTALL OLECMDID\_CLEARSELECTION

OLECMDID\_ZOOM OLECMDID\_GETZOOMRANGE OLECMDID\_UPDATECOMMANDS

OLECMDID\_REFRESH OLECMDID\_STOP OLECMDID\_HIDETOOLBARS

OLECMDID\_SETPROGRESSMAX OLECMDID\_SETPROGRESSPOS

OLECMDID\_SETPROGRESSTEXT

OLECMDID\_SETTITLE OLECMDID\_SETDOWNLOADSTATE OLECMDID\_STOPDOWNLOAD

OLECMDID\_FIND OLECMDID\_ONTOOLBARACTIVATED OLECMDID\_DELETE

OLECMDID\_HTTPEQUIV OLECMDID\_ENABLE\_INTERACTION
OLECMDID\_HTTPEQUIV\_DONE

OLECMDID\_ONUNLOAD OLECMDID\_PROPERTYBAG2 OLECMDID\_PREREFRESH

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>
