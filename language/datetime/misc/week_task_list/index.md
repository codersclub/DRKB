---
Title: Генерация еженедельных списков задач
Author: Mike Orriss
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Генерация еженедельных списков задач
====================================

> Мне необходима программа, которая генерировала бы еженедельные списки
> задач. Программа должна просто показывать количество недель в списке
> задач и организовывать мероприятия, не совпадающие по времени. В моем
> текущем планировщике у меня имеется 12 групп и планы на 11 недель.
> 
> Мне нужен простой алгоритм, чтобы решить эту проблему. Какие идеи?

Вот рабочий код (но вы должны просто понять алгоритм работы):

    unit Unit1;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
      StdCtrls;
     
    type
      TForm1 = class(TForm)
        ListBox1: TListBox;
        Edit1: TEdit;
        Button1: TButton;
        procedure Button1Click(Sender: TObject);
      private
        { Private declarations }
      public
        { Public declarations }
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    const
      maxTeams = 100;
    var
      Teams: array[1..maxTeams] of integer;
      nTeams, ix, week, savix: integer;
     
    function WriteBox(week: integer): string;
    var
      str: string;
      ix: integer;
    begin
      Result := Format('Неделя=%d ', [week]);
      for ix := 1 to nTeams do
      begin
        if odd(ix) then
          Result := Result + ' '
        else
          Result := Result + 'v';
        Result := Result + IntToStr(Teams[ix]);
      end;
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      nTeams := StrToInt(Edit1.Text);
      if Odd(nTeams) then
        inc(nTeams); {должны иметь номера каждой группы}
      ListBox1.Clear;
      for ix := 1 to nTeams do
        Teams[ix] := ix;
      ListBox1.Items.Add(WriteBox(1));
     
      for week := 2 to nTeams - 1 do
      begin
        Teams[1] := Teams[nTeams - 1];
          {используем Teams[1] в качестве временного хранилища}
        for ix := nTeams downto 2 do
          if not Odd(ix) then
          begin
            savix := Teams[ix];
            Teams[ix] := Teams[1];
            Teams[1] := savix;
          end;
        for ix := 3 to nTeams - 1 do
          if Odd(ix) then
          begin
            savix := Teams[ix];
            Teams[ix] := Teams[1];
            Teams[1] := savix;
          end;
        Teams[1] := 1; {восстанавливаем известное значение}
        ListBox1.Items.Add(WriteBox(week));
      end;
    end;
     
    end. 

