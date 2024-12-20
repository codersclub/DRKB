---
Title: Как выдвинуть дверцу CD-ROM?
Date: 01.01.2007
---


Как выдвинуть дверцу CD-ROM?
============================

Вариант 1:

Source: <https://blackman.wp-club.net/>

    mciSendString('Set cdaudio Door Open Wait', nil, 0, handle);
    mciSendCommand(mp.DeviceID, MCI_SET, MCI_SET_DOOR_CLOSED, 0);


------------------------------------------------------------------------

Вариант 2:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

Основываясь, на этой возможности можно написать классную прогу.
Представьте себе: ламерюга с умным видом тайпает какой-нибудь док, а тут
его сидюк начинает вести себя как взбесившийся: то откроется, то
закроется, то откроется, то закроется, то откроется, то закроется, то
откроется, то закроется, то откроется, то закроется, то откроется, то
закроется, то откроется, то закроется, то откроется, то закроется...

и так, например, каждый час... (или минуту...или секунду...)

Для начала научимся открывать CD-ROM по нажатию простого "батона":

В uses нужно сначала объявить модуль MMSystem:

    uses
      MMSystem;

По нажатию кнопок написать:

    //Для открытия
    procedure TForm1.OpenBtnClick(Sender: TObject);
    begin
      mciSendString('Set cdaudio door open wait', nil, 0, handle);
    end;
     
    //Для закрытия
    procedure TForm1.CloseBtnClick(Sender: TObject);
    begin
      mciSendString('Set cdaudio door closed wait', nil, 0, handle);
    end;

Ну а если вы уж хотите, чтобы это всё происходило автоматически с
периодичностью в несколько минут, тогда выносим наш любимый компонент -
Timer. Устанавливаем его свойство Interval в 30000 миллисекунд - это 30
секунд, т.е. каждые полминуты глупый ламерюга будет подскакивать...И на
событие OnTimer, предвкушая удовольствие, пишем: сначала в публичных
объявлениях объявим переменную логического типа IsOpen для обозначения
времени когда открыт CD-ROM

    public
      { Public declarations }
      IsOpen: boolean;

По созданию окна (OnCreate) устанавливаем эту переменную в false, т.к.
изначально, когда наша прога только запускается, CD-ROM не открыт:

    procedure TForm1.FormCreate(Sender: TObject);
    begin
      IsOpen := false;
    end;

И наконец, по таймеру пишем:

    procedure TForm1.Timer1Timer(Sender: TObject);
    begin
      if IsOpen = false then
      begin
        mciSendString('Set cdaudio door open wait', nil, 0, handle);
        IsOpen:=true;
      end
      else
      begin
        mciSendString('Set cdaudio door closed wait', nil, 0, handle);
        IsOpen:=false;
      end;
    end;



------------------------------------------------------------------------

Вариант 3:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

    // Данная прога извлекает и закравет CD-ROM выбранные в Combobox1
    // На форме разместите Button1, Button2 и Combobox1
     
    uses
      Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
      Dialogs, StdCtrls, ComCtrls, MMSystem;
     
    type
      TForm1 = class(TForm)
        Button1: TButton;
        Button2: TButton;
        ComboBox1: TComboBox;
        procedure Button1Click(Sender: TObject);
        function CloseCD(Drive : string) : Boolean;
        function OpenCD(Drive : string) : Boolean;
        procedure FormCreate(Sender: TObject);
        procedure Button2Click(Sender: TObject);
      private
      public
    end;
     
    var
      Form1: TForm1;
      Driv: array [1..25] of string;
     
    implementation
     
    {$R *.dfm}
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      OpenCD(ComboBox1.Text);
    end;
     
    function TForm1.OpenCD(Drive: string): Boolean;
    var
      Res : MciError;
      OpenParm: TMCI_Open_Parms;
      Flags : DWord;
      S : string;
      DeviceID : Word;
    begin
      Result:=false;
      S:=Drive;
      Flags:=mci_Open_Type or mci_Open_Element;
      with OpenParm do
      begin
        dwCallback := 0;
        lpstrDeviceType := 'CDAudio';
        lpstrElementName := PChar(S);
      end;
      Res := mciSendCommand(0, mci_Open, Flags, Longint(@OpenParm));
      if Res<>0 then
        exit;
      DeviceID:=OpenParm.wDeviceID;
      try
        Res:=mciSendCommand(DeviceID, MCI_SET, MCI_SET_DOOR_OPEN, 0);
        if Res=0 then
          exit;
        Result:=True;
      finally
        mciSendCommand(DeviceID, mci_Close, Flags, Longint(@OpenParm));
      end;
    end;
     
    function TForm1.CloseCD(Drive: string): Boolean;
    var
      Res : MciError;
      OpenParm: TMCI_Open_Parms;
      Flags : DWord;
      S : string;
      DeviceID : Word;
    begin
      Result:=false;
      S:=Drive;
      Flags:=mci_Open_Type or mci_Open_Element;
      with OpenParm do
      begin
        dwCallback := 0;
        lpstrDeviceType := 'CDAudio';
        lpstrElementName := PChar(S);
      end;
      Res := mciSendCommand(0, mci_Open, Flags, Longint(@OpenParm));
      if Res<>0 then
        exit;
      DeviceID:=OpenParm.wDeviceID;
      try
        Res:=mciSendCommand(DeviceID, MCI_SET, MCI_SET_DOOR_CLOSED, 0);
        if Res=0 then
          exit;
        Result:=True;
      finally
        mciSendCommand(DeviceID, mci_Close, Flags, Longint(@OpenParm));
      end;
    end;
     
    procedure TForm1.FormCreate(Sender: TObject);
    var
      w:dword;
      Root:string;
      I, K:integer;
    begin
      k:=0;
      w:=GetLogicalDrives;
      Root := '#:';
      for i := 0 to 25 do
      begin
        Root[1] := Char(Ord('A')+i);
        if (W and (1 shl i))>0 then
          if GetDriveType(Pchar(Root)) = DRIVE_CDROM then
          begin
            k:=k+1;
            Driv[k] := Root;
            ComboBox1.Items.Add(Driv[k]);
            ComboBox1.Text := Driv[1];
          end;
      end;
    end;
     
    procedure TForm1.Button2Click(Sender: TObject);
    begin
      CloseCD(ComboBox1.Text);
    end;
     
    end.


