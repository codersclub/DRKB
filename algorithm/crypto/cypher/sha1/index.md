---
Title: Шифрование SHA-1
Date: 01.01.2007
---


Шифрование SHA-1
================

    unit main;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, StdCtrls,
      Dialogs;
     
    type
      TForm1 = class(TForm)
        Memo1: TMemo;
        Button1: TButton;
        Button2: TButton;
        Button3: TButton;
        Button4: TButton;
        CheckBox1: TCheckBox;
        CheckBox2: TCheckBox;
        CheckBox3: TCheckBox;
        BStop: TButton;
        SaveDialog1: TSaveDialog;
        OpenDialog1: TOpenDialog;
        procedure FormCreate(Sender: TObject);
        procedure Button1Click(Sender: TObject);
        procedure Button2Click(Sender: TObject);
        procedure FormResize(Sender: TObject);
        procedure Button3Click(Sender: TObject);
        procedure Button4Click(Sender: TObject);
        procedure BStopClick(Sender: TObject);
      private   { Private declarations }
      public    { Public declarations }
      end;
    var
      Form1: TForm1;
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    const
      HC0=$67452301;
      HC1=$EFCDAB89;
      HC2=$98BADCFE;
      HC3=$10325476;
      HC4=$C3D2E1F0;
     
      K1=$5A827999;
      K2=$6ED9EBA1;
      K3=$8F1BBCDC;
      K4=$CA62C1D6;
     
     
    var H0,H1,H2,H3,H4:integer;  Hout:string;  //Hout - результат
        StopScan:boolean;
    implementation
    {$R *.DFM}
     
    function rol(const x:integer;const y:byte):integer ;     //сдвиг числа x на y бит влево
    begin
      asm
        mov  eax,x
        mov  cl, y
        rol  eax,cl
        mov  x, eax
      end;
      result:=x;
    end;
     
    procedure INIT;        //Инициализация - присвоить пересенным значения констант
    begin
      H0:=HC0;//$67452301;
      H1:=HC1;//$EFCDAB89;
      H2:=HC2;//$98BADCFE;
      H3:=HC3;//$10325476;
      H4:=HC4;//$C3D2E1F0;
      Hout:='';
    end;
     
    function PADDING(s:string;FS:integer):string;     //добавление одного бита (1000000=128) и добавление нулей до кратности 64 байтам
    var size,i:integer;
    begin
    size:=Length(s)*8;   //size -входной размер в битах
    s:=s+char(128);    //добавление одного бита  (1000000=128)
     
    while (Length(s) mod 64) <>0 do s:=s+#0;     //добавление нулей до кратности 64  байтам
     
    //############   #############    //   IF  ((size) >= 448) then // OLD
     
    IF  ((size mod 512) >= 448) then         // если хвост превышает 48 байт то добавить пустой блок из 64 нулей
                        begin
                          s:=s+#0;                                 //добавление нулей до кратности 64
                          while (Length(s) mod 64) <>0 do s:=s+#0;
                        end;
     
          i:=Length(s);size:=FS*8;
          while size > 0 do             //запись в конец строки её размер
          begin
          s[i]:=char(byte(size));      //получение младшего байта
          size:=size shr 8;            //сдвиг вправо на 8 бит - перенос старшего байта на место младшего
          i:=i-1;
          end;
    Result:=s;
    end;
     
     
    Procedure START(const S_IN:string);
    var    A,B,C,D,E,TEMP:integer;    t,i:byte;    W:array[0..79] of integer;  
    begin
     
      t:=1;
      for i:=1 to ((Length(S_IN)) div 4) do
      begin
       // W[i-1]:=ord(S_IN[t])*256*256*256+ord(S_IN[t+1])*256*256+ord(S_IN[t+2])*256+ord(S_IN[t+3]);
        W[i-1]:=(ord(S_IN[t]) shl 24) +(ord(S_IN[t+1]) shl 16)+(ord(S_IN[t+2]) shl 8)+ord(S_IN[t+3]);
        t:=t+4;
      end;
     
     
      For t:=16 to 79 do W[t]:=ROL(W[t-3] XOR W[t-8] XOR W[t-14] XOR W[t-16],1);
     
      A:=H0;B:=H1;C:=H2;D:=H3;E:=H4;
     
    {  for t:=0 to 79 do                            // Разделить на 4 цикла !!!  * * * * * * * * * * * * * * *
        begin
           if (t>=0)  AND (t<=19) then  TEMP:=ROL(A,5)+((B AND C) OR ((NOT B) AND D))       +E+K1+W[t];
           if (t>=20) AND (t<=39) then  TEMP:=ROL(A,5)+(B XOR C XOR D)                      +E+K2+W[t];
           if (t>=40) AND (t<=59) then  TEMP:=ROL(A,5)+((B AND C) OR (B AND D) OR (C AND D))+E+K3+W[t];
           if (t>=60) AND (t<=79) then  TEMP:=ROL(A,5)+(B XOR C XOR D)                      +E+K4+W[t];
     
            E:=D;  D:=C;  C:=ROL(B,30);  B:=A;  A:=TEMP;
        end;
     }
       for t:=0 to 19 do
       begin
          TEMP:=ROL(A,5)+((B AND C) OR ((NOT B) AND D))       +E+K1+W[t];
          E:=D;  D:=C;  C:=ROL(B,30);  B:=A;  A:=TEMP;
       end;
       for t:=20 to 39 do
       begin
          TEMP:=ROL(A,5)+(B XOR C XOR D)                      +E+K2+W[t];
          E:=D;  D:=C;  C:=ROL(B,30);  B:=A;  A:=TEMP;
       end;
       for t:=40 to 59 do
       begin
          TEMP:=ROL(A,5)+((B AND C) OR (B AND D) OR (C AND D))+E+K3+W[t];
          E:=D;  D:=C;  C:=ROL(B,30);  B:=A;  A:=TEMP;
       end;
       for t:=60 to 79 do
       begin
          TEMP:=ROL(A,5)+(B XOR C XOR D)                      +E+K4+W[t];
          E:=D;  D:=C;  C:=ROL(B,30);  B:=A;  A:=TEMP;
       end;
     
       H0:=A+H0; H1:=B+H1; H2:=C+H2; H3:=D+H3; H4:=E+H4;
    //Form1.memo1.Lines.Add(inttohex(H0,8)+' '+inttohex(H1,8)+' '+inttohex(H2,8)+' '+inttohex(H3,8)+' '+inttohex(H4,8));
    end;
     
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      WindowState:=wsMaximized;
      Form1.Memo1.Clear;
      Button2.Enabled:=false ;
      Form1.SaveDialog1.Filter := 'Text Files (*.txt)|*.TXT|All Files (*.*)|*.*';
      CheckBox1.Checked:=true;
      CheckBox2.Checked:=true;
      Application.Title:='SHA-1';
      Caption:='SHA-1';
    end;
     
     
     
    procedure Work(Z:string);
    var s,s1:string;    i,L,FS:integer;        F:file;  n:integer; Buf: array[1..65536] of char;
    begin
       Application.ProcessMessages;
       IF StopScan then exit;
       s:='';
       AssignFile(F,Z);
       FileMode := FmOpenRead;
       Reset(F,1);
       FS:=FileSize(F);
    INIT;
       repeat
          BlockRead(F,Buf,sizeOf(Buf),n);
          SetLength(s1,n);
          For i:=1 to n do s1[i]:=Buf[i];
         // s:=s+s1;
         s:=s1;
         L:=length(s1);
         IF ((L<65536) and (L>0)) then
         begin
              s1:= PADDING(s,FS) ;
                     i:=1;
                     L:=length(s1);
                     while i<L do
                     begin
                     START(copy(s1,i,64));
                     i:=i+64;
                     end;
         end;
     
         IF L =65536  then begin
                     i:=1;
                     L:=length(s1);
                     while i<L do
                     begin
                     START(copy(s1,i,64));
                     i:=i+64;
                     end;
     
                     end;
     
     
          until n=0;
       CloseFile(F);
     
     {
    INIT;
    s:=PADDING(s,FS) ;
    L:=length(s);
     
    i:=1;
    while i<L do
          begin
          START(copy(s,i,64));
          i:=i+64;
          end;
          }
          Hout:=inttohex(H0,8)+' '+inttohex(H1,8)+' '+inttohex(H2,8)+' '+inttohex(H3,8)+' '+inttohex(H4,8);
          s1:=Hout;
          If (Form1.CheckBox1.Checked AND Form1.CheckBox2.Checked) then
              Form1.memo1.Lines.Add(s1+'        '+inttostr(FS)+'        '+ExtractFileName(Z));
          If NOT ((Form1.CheckBox1.Checked AND Form1.CheckBox2.Checked)) then
              Form1.memo1.Lines.Add(s1);
          If (Form1.CheckBox1.Checked AND NOT Form1.CheckBox2.Checked) then
              Form1.memo1.Lines.Add(s1+'        '+inttostr(FS));
          If (NOT Form1.CheckBox1.Checked AND Form1.CheckBox2.Checked) then
              Form1.memo1.Lines.Add(s1+'        '+ExtractFileName(Z));
     
    // abc.....opq = 84983E44 1C3BD26E BAAE4AA1 F95129E5 E54670F1
    // abcdbcdecdefdefgefghfghighijhijkijkljklmklmnlmnomnopnopqW = 39958831d7dd0a53e9bfba578cdf45e5ec542e8c
    //abc = A9993E36 4706816A BA3E2571 7850C26C 9CD0D89D;
    //abcdbcdecdefdefgefghfghighijhijkijkljklmklmnlmnomnopnop = 47B17281 0795699F E739197D 1A1F5960 700242F1
     
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
    if Form1.OpenDialog1.Execute then
       begin
     
          StopScan:=false;
          Work(OpenDialog1.FileName);
          Button2.Enabled:=true;
       end;
    end;
     
     
    Function ScanDir(Dir:string):string;
    var   SearchRec:TSearchRec; //scan_result :string;
    begin
    Application.ProcessMessages;
    IF StopScan then exit;
    if Dir<>'' then if Dir[length(Dir)]<>'\' then Dir:=Dir+'\';
     
    if FindFirst(Dir+'*.*', faAnyFile, SearchRec)=0   then
    repeat
      if (SearchRec.name='.') or (SearchRec.name='..')   then continue;
      if  ( (SearchRec.Attr and faDirectory)<>0) then
                            begin
                              IF Form1.CheckBox3.Checked then ScanDir(Dir+SearchRec.name)
                            end
      else Work(Dir+SearchRec.name);
    until FindNext(SearchRec)<>0;
    FindClose(SearchRec);
     
    end;
     
     
    procedure TForm1.Button2Click(Sender: TObject);       //Scan Button pressed
    begin
      IF  Button2.Enabled=false then exit;
      StopScan:=false;
      Caption:='Scanning ...';
      ScanDir(ExtractFileDir(Form1.OpenDialog1.FileName));
      Caption:='SHA-1';
    end;
     
    procedure TForm1.FormResize(Sender: TObject);
    begin
      Memo1.Height:=Height-70;
    end;
     
    procedure TForm1.Button3Click(Sender: TObject);
    begin
    If SaveDialog1.Execute then
       begin
         If FileExists(SaveDialog1.FileName) then
               IF  MessageDlg('File'+#13+SaveDialog1.FileName+#13+'already exists!'
                   +#13+#13+'Overwrite (Yes/No) ?',mtWarning, [mbYes, mbNo], 0) = mrNo then exit;
         Memo1.Lines.SaveToFile(SaveDialog1.FileName);
     
       end;
    end;
     
    procedure TForm1.Button4Click(Sender: TObject);
    begin
      Form1.Memo1.Clear;
    end;
     
    procedure TForm1.BStopClick(Sender: TObject);
    begin
    StopScan:=true;
    end;
     
    end.
