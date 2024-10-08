---
Title: Показать контекстное меню на панели задач
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---

Показать контекстное меню на панели задач
=========================================

    unit TNA;
     
    interface
    
    uses
      Windows, Messages, SysUtils, Classes, Controls, Forms, ExtCtrls,
      ShellApi, Menus;
    
    const
      k_WM_TASKMSG = WM_APP + 100;  //die "100" ist ein frei wahlbarer Wert 
     
    type
      TForm1 = class(TForm)
        TPopupMenu1: TPopupMenu;
        procedure FormCreate(Sender: TObject);
        procedure FormClose(Sender: TObject; var Action: TCloseAction);
        procedure FormDblClick(Sender: TObject);
        procedure PopupMenuClick(Sender: TObject);
      private
        { Private-Deklarationen }
        tTNA: TNotifyIconData;
    
        procedure WMTaskMsg(var Msg: TMessage); message k_WM_TASKMSG;
        procedure AppActive;
        procedure AppDeactivate;
        procedure ShowIcon;
        procedure ChangeIcon;
    
      public
        { Public-Deklarationen }
      end;
    
    var
      Form1: TForm1;
    
    implementation
    
    
    {$R *.DFM}
    {$R TNA.RES} //eine Resource mit 2 Icons oder Bitmaps 
     
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      {la?t die Form schon bei Programmstart verschwinden}
      Application.ShowMainForm := False;
    
      {Symbol im TNA anzeigen}
      Self.ShowIcon;
    end;
    
    
    procedure TForm1.FormClose(Sender: TObject; var Action: TCloseAction);
    begin
      {Symbol aus dem TNA entfernen}
      Shell_NotifyIcon(NIM_DELETE, @tTNA);
    end;
    
    
    procedure TForm1.FormDblClick(Sender: TObject);
    begin
      {lassen wir doch die Form wieder verschwinden ...}
      Self.AppDeactivate;
    
      {... und andern das Symbol in dem TNA}
      Self.ChangeIcon;
    end;
    
    
    procedure TForm1.PopupMenuClick(Sender: TObject);
    begin
      case TPopupMenu(Sender).Tag of
    
        {hier steht dann die Auswahl was getan werden soll}
        {wenn auf das erschienene Popupmenu geklickt wurde}
      end;
    end;
    
    
    procedure TForm1.WMTaskMsg(var Msg: TMessage);
    var
      rCursor: TPoint;
    begin
      {wenn die Nachricht aus unserem definierten Bereich kommt dann ...}
      if Msg.wParam = tTNA.uID then
      begin
        {... tu was wenn das Ereignis ein ...}
        case Msg.lParam of
    
          {... rechter Mausklick ist oder ...}
          WM_RBUTTONDOWN:
            begin
              {aktuelle Cursoposition holen}
              GetCursorPos(rCursor);
    
              {ACHTUNG!!!!! Der folgende Aufruf ist an dieser Stelle ganz wichtig!!!!}
              {Erst durch diese API-Funktion wird das Popupmenu dazu bewegt zu verschwinden 
               wenn ein Klick au?erhalb des Popupmenus erfolgt}
    
              SetForegroundWindow(Self.Handle);
    
              {Also, nicht vergessen!!!}
    
              {Das Popupmenu erscheint an der gewunschten Position in dem TNA}
              TPopupMenu1.Popup(rCursor.x, rCursor.y);
            end;
    
          {... ein linker doppelter Mausklick ist}
          WM_LBUTTONDBLCLK: Self.AppActive;
        end;
      end;
    end;
    
    
    procedure TForm1.AppActive;
    var
      hOwner: THandle;
    begin
      {Form einblenden}
      SendMessage(Self.Handle, WM_SYSCOMMAND, SC_RESTORE, 0);
      ShowWindow(Self.Handle, SW_SHOW);
      SetForegroundWindow(Self.Handle);
    
      {Symbol in der Taskbar einblenden}
      hOwner := GetWindow(Self.Handle, GW_OWNER);
      SendMessage(hOwner, WM_SYSCOMMAND, SC_RESTORE, 0);
      ShowWindow(hOwner, SW_SHOW);
    end;
    
    
    procedure TForm1.AppDeactivate;
    begin
      {Form ausblenden}
      ShowWindow(Self.Handle, SW_HIDE);
    
      {Symbol in der Taskbar ausblenden}
      ShowWindow(GetWindow(Self.Handle, GW_OWNER), SW_HIDE);
    end;
    
    
    procedure TForm1.ShowIcon;
    begin
      tTNA.cbSize := SizeOf(tTNA);
      tTNA.Wnd    := Self.Handle;
      tTNA.uID    := 24112000;                     //frei wahlbarer Wert zur Identifizierung 
      tTNA.uCallbackMessage := k_WM_TASKMSG;
      tTNA.hIcon  := LoadIcon(hInstance, 'xxx');
      //xxx ist die Bezeichnung eines Icons aus "TNA.res" 
      StrCopy(tTNA.szTip, 'Hallo');             //Hint 
      tTNA.uFlags := NIF_MESSAGE or NIF_ICON or NIF_TIP;
      {CB Symbol in dem TNA einrichten CE}
      Shell_NotifyIcon(NIM_ADD, @tTNA);
    end;
    
    
    procedure TForm1.ChangeIcon;
    begin
      tTNA.cbSize := SizeOf(tTNA);
      tTNA.hIcon  := LoadIcon(hInstance, 'yyy');
      //yyy ist die Bezeichnung eines weiteren Icons aus "TNA.res" 
      StrCopy(tTNA.szTip, 'Welt');              //Hint 
    
      {CB Symbol im TNA andern CE}
      Shell_NotifyIcon(NIM_MODIFY, @tTNA);
    end;
    
    
    end.

