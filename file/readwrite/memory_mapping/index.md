---
Title: Пример работы с Memory Mapped Files
Date: 23.05.2003
author: Александр (Rouse\_) Багель <https://rouse.drkb.ru>
---


Пример работы с Memory Mapped Files
===================================

Пример, показывающий принцип работы с Memory Mapped Files.

```delphi
////////////////////////////////////////////////////////////////////////////////
//
//  Демо работы с Файлами отображенными в память процесса
//  Автор: Александр (Rouse_) Багель
//  © Fangorn Wizards Lab 1998 - 2003
//  23 мая 2003 17:06

// Закоментированные строки содержат пример передачи структуры 

unit Unit1;

interface

uses
  Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms,
  Dialogs, StdCtrls;

const
  MMFID = '{D9CFD3BD-3E91-4748-B9F9-7A1825847DF7}';

type
  {
  PTestStructure = ^TTestStructure;
  TTestStructure = packed record
    A: Integer;
    B: Boolean;
    C: ShortString;
  end;}

  TForm1 = class(TForm)
    memSender: TMemo;
    btnCreate: TButton;
    memReceive: TMemo;
    btnAdd: TButton;
    btnClose: TButton;
    btnOpen: TButton;
    btnRead: TButton;
    btnCloseOpen: TButton;
    procedure btnAddClick(Sender: TObject);
  private
    TextAdded,           // Два флага для
    IsOpenFile: Boolean; // для управления состоянием кнопок
    SendMMF, RecMMF: THandle;
    SendData, RecData: PChar;
    procedure ButtonState(const btnState: Integer);
    function OpenSendMMF: Boolean;
    function AddText: Boolean;
    function CloseSend: Boolean;
    function OpenRecMMF: Boolean;
    function ReadText: Boolean;
    function CloseRec: Boolean;
  end;

var
  Form1: TForm1;

implementation

{$R *.dfm}


//  Управляем состоянием кнопок
//  Кнопки становятся доступными в тот момент, когда текущая операция,
//  содержащаяся в обработчике кнопки, возможна ...
// =============================================================================
procedure TForm1.ButtonState(const btnState: Integer);
begin
  case btnState of
    0:
    begin
      btnAdd.Enabled := True;
      btnClose.Enabled := True;
      btnOpen.Enabled := True;
    end;
    1:
    begin
      TextAdded := True;
      btnRead.Enabled := IsOpenFile;
    end;
    2:
    begin
      TextAdded := False;
      btnAdd.Enabled := False;
      btnClose.Enabled := False;
      btnOpen.Enabled := False;
      btnRead.Enabled := False;
      btnCloseOpen.Enabled := False;
    end;
    3:
    begin
      IsOpenFile := True;
      btnCloseOpen.Enabled := True;
      btnRead.Enabled := TextAdded;
    end;
    5:
    begin
      IsOpenFile := False;
      btnRead.Enabled := False;
      btnCloseOpen.Enabled := False;
    end;
  end;
end;


//  Общий обработчик для всех кнопок ...
// =============================================================================
procedure TForm1.btnAddClick(Sender: TObject);
var
  State: Boolean;
begin
  State := False;
  case TComponent(Sender).Tag of
    0: State := OpenSendMMF;
    1: State := AddText;
    2: State := CloseSend;
    3: State := OpenRecMMF;
    4: State := ReadText;
    5: State := CloseRec;
  end;
  if State then
    ButtonState(TComponent(Sender).Tag);
end;


//  Создаем Memory Mapped File ...
// =============================================================================
function TForm1.OpenSendMMF: Boolean;
begin
  SendMMF := CreateFileMapping($FFFFFFFF, nil, PAGE_READWRITE, 0, 4096,
    PChar(MMFID));
  Result := SendMMF <> 0;
end;


//  Добавляем в файл текст ...
//  (передача структуры находится в закоментированных строках кода)
// =============================================================================
function TForm1.AddText: Boolean;
{var
  F: TTestStructure;
  Z: PTestStructure;}
begin
  SendData := MapViewOfFile(SendMMF, FILE_MAP_WRITE, 0, 0, 0);
  Result := SendData <> nil;
  StrPCopy(SendData, memSender.Text);

  {F.A := 123;
  F.B := True;
  F.C := 'This is are test message';
  Z := MapViewOfFile(SendMMF, FILE_MAP_WRITE, 0, 0, 0);
  Result := Z <> nil;
  Z^ := F;}        
end;


//  Разрушаем Memory Mapped File ...
// =============================================================================
function TForm1.CloseSend: Boolean;
begin
  if btnCloseOpen.Enabled then CloseRec;
  UnmapViewOfFile(SendData);
  SendData := nil;
  CloseHandle(SendMMF);
  Result := True;
end;


//  Открываем созданный ранее Memory Mapped File ...
// =============================================================================
function TForm1.OpenRecMMF: Boolean;
begin
  RecMMF := OpenFileMapping(FILE_MAP_ALL_ACCESS, False, PChar(MMFID));
  Result := RecMMF <> 0;
end;


//  Читаем из него данные ...
//  (прием структуры находится в закоментированных строках кода)
// =============================================================================
function TForm1.ReadText: Boolean;
{var
  F: TTestStructure;
  Z: PTestStructure;}
begin
  RecData := MapViewOfFile(RecMMF, FILE_MAP_ALL_ACCESS, 0, 0, 0);
  Result := RecData <> nil;
  memReceive.Text := RecData;

  {Z := MapViewOfFile(SendMMF, FILE_MAP_ALL_ACCESS, 0, 0, 0);
  F := Z^;
  Result := Z <> nil;
  Caption := F.C;}
end;


//  Закрываем (не разрушаем) Memory Mapped File ...
// =============================================================================
function TForm1.CloseRec: Boolean;
begin                      
  UnmapViewOfFile(RecData);
  RecData := nil;
  CloseHandle(RecMMF);
  Result := True;
end;      

end.
```


[Скачать демонстрационный пример](mmf.zip)
