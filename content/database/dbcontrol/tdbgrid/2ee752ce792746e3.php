<h1>TDBGrid &ndash; сохранение конфигурации</h1>
<div class="date">01.01.2007</div>


<p>Нижеописанный код создает, сохраняет и загружает конфигурационный файл и изменяет размеры столбцов таблицы DBGRID </p>
<pre>
uses
  Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms,
  Dialogs, Grids, DBGrids, Db, DBTables, StdCtrls, IniFiles;
...
 
procedure TMainForm.NewIni(const NomeIni: string);
var
  F: System.Text;
  i: Byte;
begin
  System.Assign(F, NomeIni);
  System.ReWrite(F);
  System.WriteLn(F, '[Campi_Ordine]');
  for i:=1 to Table1.FieldCount do
    System.WriteLn(F, 'Campo',i,'=',Table1.Fields[i-1].FieldName);
  System.WriteLn(F, '');
  System.WriteLn(F, '[Campi_Size]');
  for i:=1 to Table1.FieldCount do
    System.WriteLn(F, 'Campo',i,'=',Table1.Fields[i-1].DisplayWidth);
  System.Close(F);
end;
 
procedure TMainForm.SaveIni(const FN: string);
var
  Ini: TIniFile;
  i: Integer;
  S : string;
begin
  NewIni(FN);
  Ini := TIniFile.Create(FN);
  with Ini do begin
    for i:=1 to Table1.FieldCount do
    begin
      S:= Table1.Fields[i-1].FieldName;
      WriteString('Campi_Ordine', 'Campo'+IntToStr(i),
      Table1.Fields[i-1].FieldName);
      WriteInteger('Campi_Size', 'Campo'+IntToStr(i),
      Table1.Fields[i-1].DisplayWidth);
    end;
  end;
  Ini.Free;
end;
 
procedure TMainForm.LoadIni(const FN: string);
var
  Ini: TIniFile;
  i: Integer;
  j: Longint;
  S: string;
 
  function MyReadInteger(const Section, Ident: string): Longint;
  begin
    result := Ini.ReadInteger(Section, Ident, -1);
    if result=-1 then
      raise Exception.Create('Errore nel file di configurazione.');
  end;
 
  function MyReadString(const Section, Ident: string): string;
  begin
    result := Ini.ReadString(Section, Ident, '');
    if result='' then
      raise Exception.Create('Errore nel file di configurazione.');
  end;
 
begin
  Ini := TIniFile.Create(FN);
  try
    with Ini do
    begin
      for i:=1 to Table1.FieldCount do
      begin
        S:= MyReadString('Campi_Ordine', 'Campo'+IntToStr(i));
        j:= MyReadInteger('Campi_Size', 'Campo'+IntToStr(i));
        Table1.FieldByName(S).index := i-1;
        Table1.FieldByName(S).DisplayWidth := j;
      end;
    end;
  finally
    Ini.Free;
  end;
end;
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

