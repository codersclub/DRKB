---
Title: Как вызвать скрытые команды TWebBrowser?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Как вызвать скрытые команды TWebBrowser?
========================================

    // The following codes demonstrates an innovative way to invoke hidden
    // commands to show modal dialogs such as "Add To Favorite" dialog,
    // "Import/Export Wizard" dialog in your WebBrowser-based application
     
    //Command IDs Handled by 'Shell DocObject View'
    const ID_IE_FILE_PAGESETUP           = 259;
    const ID_IE_FILE_PRINT               = 260;
    const ID_IE_FILE_NEWWINDOW           = 275;
    const ID_IE_FILE_PRINTPREVIEW        = 277;
    const ID_IE_FILE_NEWMAIL             = 279;
    const ID_IE_FILE_SENDPAGE            = 282;
    const ID_IE_FILE_SENDLINK            = 283;
    const ID_IE_FILE_SENDDESKTOPSHORTCUT = 284;
    const ID_IE_HELP_VERSIONINFO         = 336;
    const ID_IE_HELP_HELPINDEX           = 337;
    const ID_IE_HELP_WEBTUTORIAL         = 338;
    const ID_IE_HELP_FREESTUFF           = 341;
    const ID_IE_HELP_PRODUCTUPDATE       = 342;
    const ID_IE_HELP_FAQ                 = 343;
    const ID_IE_HELP_ONLINESUPPORT       = 344;
    const ID_IE_HELP_FEEDBACK            = 345;
    const ID_IE_HELP_BESTPAGE            = 346;
    const ID_IE_HELP_SEARCHWEB           = 347;
    const ID_IE_HELP_MSHOME              = 348;
    const ID_IE_HELP_VISITINTERNET       = 349;
    const ID_IE_HELP_STARTPAGE           = 350;
    const ID_IE_HELP_NETSCAPEUSER        = 351;
    const ID_IE_FILE_IMPORTEXPORT        = 374;
    const ID_IE_HELP_ENHANCEDSECURITY    = 375;
    const ID_IE_FILE_ADDTRUST            = 376;
    const ID_IE_FILE_ADDLOCAL            = 377;
    const ID_IE_FILE_NEWPUBLISHINFO      = 387;
    const ID_IE_FILE_NEWPEOPLE           = 390;
    const ID_IE_FILE_NEWCALL              =395;
     
    //Command IDs Handled by 'Internet Explorer_Server'
    const ID_IE_CONTEXTMENU_NEWWINDOW    = 2137;
    const ID_IE_CONTEXTMENU_ADDFAV       = 2261;
    const ID_IE_CONTEXTMENU_REFRESH      = 6042;
     
    function GetIEHandle(WebBrowser: TWebbrowser; ClassName: string): HWND;
    var
      hwndChild, hwndTmp: HWND;
      oleCtrl: TOleControl;
      szClass: array [0..255] of char;
    begin
      oleCtrl :=WebBrowser;
      hwndTmp := oleCtrl.Handle;
      while (true) do
      begin
        hwndChild := GetWindow(hwndTmp, GW_CHILD);
        GetClassName(hwndChild, szClass, SizeOf(szClass));
        if (string(szClass)=ClassName) then
        begin
          Result :=hwndChild;
          Exit;
        end;
        hwndTmp := hwndChild;
      end;
      Result := 0;
    end;
     
    procedure TForm1.ToolButton2Click(Sender: TObject);
    begin
      //Invoke "Add To Favorite" Dialog
      SendMessage(GetIEHandle(web, 'Internet Explorer_Server'), WM_COMMAND, ID_IE_CONTEXTMENU_ADDFAV, 0);
    end;
     
    procedure TForm1.ToolButton3Click(Sender: TObject);
    begin
      //Invoke "Import/Export Wizard" Dialog
      SendMessage(GetIEHandle(web, 'Shell DocObject View'), WM_COMMAND, ID_IE_FILE_IMPORTEXPORT, 0);
    end;
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      web.Go('http://http://www.swissdelphicenter.ch/en');
    end;

