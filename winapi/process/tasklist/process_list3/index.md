---
Title: Просмотрщик запущенных процессов
Author: Василий
Date: 01.01.2007
Source: <https://forum.sources.ru>
---

Просмотрщик запущенных процессов
================================

Программа не видна по Ctrl+Alt+Del, и сама оттуда же может спрятать
любой из процессов (правда, не все с самого начала "светятся" по
Ctrl+Alt+Del) или завершить его. Простой пример для знакомства с
ToolHelp32.

В исходном коде есть недоработки, например, процедура Delproc получает в
качестве параметра строку, затем переводит ее в целочисленный
тип (integer), хотя можно передавать сразу число. Заморочка была в
проверке числа-индекса на подлинность, а так как я выдрал часть кода из
более ранней своей проги, я не стал это менять, а просто подогнал до
рабочей версии. Оптимизацией кода вы можете заняться сами по желанию(вы
можете, если хотите, а если не хотите, то вы не обязаны, вы посто могли
бы... да... :))) Программа не работала в WinNT 4.0, но в Win9x
работать должна.

    unit main;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
      ExtCtrls, tlhelp32, StdCtrls, ComCtrls, Buttons;
     
    type
      TForm1 = class(TForm)
        ListBox1: TListBox;
        Button1: TButton;
        Button2: TButton;
        Button4: TButton;
        Button5: TButton;
        StatusBar1: TStatusBar;
        Button6: TButton;
        procedure Button4Click(Sender: TObject);
        procedure FormCreate(Sender: TObject);
        procedure Button2Click(Sender: TObject);
        procedure Button1Click(Sender: TObject);
        procedure Button5Click(Sender: TObject);
        procedure ListBox1Click(Sender: TObject);
        procedure Button6Click(Sender: TObject);
      private
        { Private declarations }
        procedure ListProcesses;
        procedure Delproc(numb:string);
      public
        { Public declarations }
      end;
     
    var
      Form1: TForm1;
      processID:array[1..50] of integer;
     
    function RegisterServiceProcess(dwProcessID,dwType:integer):integer;
             stdcall;external 'kernel32.dll';
     
    implementation
     
    {$R *.DFM}
     
    procedure TForm1.delproc(numb:string);
    var
      c1:Cardinal;
      pe:TProcessEntry32;
      s1,s2:string;
      x:integer;
    begin
      x:=0;
      try
      Strtoint(numb);
      except
        Statusbar1.SimpleText:='Invalid number';
        exit;
      end;
      c1:=CreateToolHelp32Snapshot(TH32CS_SnapProcess,0);
      if c1=INVALID_HANDLE_VALUE then
      begin
        Statusbar1.SimpleText:='Process listing failed';
        exit;
      end;
      try
        pe.dwSize:=sizeof(pe);
        if Process32First(c1,pe) then
          repeat
            inc(x);
            s1:=ExtractFileName(pe.szExeFile);
            s2:=ExtractFileExt(s1);
            Delete(s1,length(s1)+1-length(s2),maxInt);
            if x=strtoint(numb) then
              if terminateprocess(OpenProcess(PROCESS_ALL_ACCESS,false,pe.th32ProcessID),1)
              then
              begin
                Statusbar1.SimpleText:='Process '+s1+' terminated.';
              end
              else
                Statusbar1.SimpleText:=('Couldnt terminate process'+pe.szExeFile);
          until not Process32Next(c1,pe);
      finally
        CloseHandle(c1);
      end;
    end;
     
    procedure Tform1.ListProcesses;
    var
      c1:Cardinal;
      pe:TProcessEntry32;
      s1,s2:string;
      x:integer;
    begin
      X:=0;
      c1:=CreateToolHelp32Snapshot(TH32CS_SnapProcess,0);
      if c1=INVALID_HANDLE_VALUE then
      begin
        Statusbar1.SimpleText:=('Информация о процессах закрыта.');
        exit;
      end;
      try
        pe.dwSize:=sizeof(pe);
        if Process32First(c1,pe) then
        repeat
          inc(x);
          s1:=ExtractFileName(pe.szExeFile);
          s2:=ExtractFileExt(s1);
          Delete(s1,length(s1)+1-length(s2),maxInt);
          Listbox1.Items.Add(Inttostr(x)+'  '+s1+'  :  '+pe.szExeFile);
          ProcessId[x]:=pe.th32ProcessID;
          //ListBox1.Items.Add(inttostr(pe.th32ProcessID));
        until not Process32Next(c1,pe);
      finally
        CloseHandle(c1);
      end;
     
    end;
    
    procedure TForm1.Button4Click(Sender: TObject);
    begin
      Close;
    end;
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      Button1.Enabled:=false;
      Button5.Enabled:=false;
      Button6.Enabled:=false;
      ListProcesses;
      if not (csDesigning in ComponentState) then
        RegisterServiceProcess(GetCurrentProcessID,1);
    end;
     
    procedure TForm1.Button2Click(Sender: TObject);
    begin
      Listbox1.Clear;
      ListProcesses;
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    var p:integer;
    begin
      //hide
      with Listbox1 do
        p:=Listbox1.Items.IndexOf(Listbox1.items[itemindex])+1;
      if not (csDesigning in ComponentState) then
        RegisterServiceProcess(ProcessID[p],1);
      with Listbox1 do
        StatusBar1.SimpleText:=(Listbox1.items[itemindex]+ ' hidden');
    end;
     
    procedure TForm1.Button5Click(Sender: TObject);
    var p:integer;
    begin
      //show
      with Listbox1 do
        p:=Listbox1.Items.IndexOf(Listbox1.items[itemindex])+1;
      if not (csDesigning in ComponentState) then
        RegisterServiceProcess(ProcessID[p],0);
      with Listbox1 do
        StatusBar1.SimpleText:=(Listbox1.items[itemindex]+ ' shown');
    end;
     
    procedure TForm1.ListBox1Click(Sender: TObject);
    begin
      Button1.Enabled:=true;
      Button5.Enabled:=true;
      Button6.Enabled:=true;
    end;
     
    procedure TForm1.Button6Click(Sender: TObject);
    var p:integer;
    begin
      with Listbox1 do
        p:=Listbox1.Items.IndexOf(Listbox1.items[itemindex])+1;
      delproc(inttostr(p));
    end;
     
    end.

