---
Title: Сумма и количество прописью, работа с падежами
Author: Eda, eda@arhadm.net.ru
Date: 13.06.2003
---


Сумма и количество прописью, работа с падежами
==============================================

    { **** UBPFD *********** by kladovka.net.ru ****
    >> Сумма и количество прописью, работа с падежами
     
    Несколько функций для работы с строками:
    function SumToString(Value : String) : string;//Сумма прописью
    function KolToStrin(Value : String) : string;//Количество прописью
    function padeg(s:string):string;//Склоняет фамилию имя и отчество (кому)
    function padegot(s:string):string;//Склоняет фамилию имя и отчество (от кого)
    function fio(s:string):string;//фамилия имя и отчество сокращенно
    function longdate(s:string):string;//Длинная дата
    procedure getfullfio(s:string;var fnam,lnam,onam:string);//Получить из строки фамилию имя и отчество сокращенно
     
    Зависимости: uses SysUtils, StrUtils,Classes;
    Автор:       Eda, eda@arhadm.net.ru, Архангельск
    Copyright:   Eda
    Дата:        13 июня 2003 г.
    ********************************************** }
     
    unit sumstr;
     
    interface
    uses
    SysUtils, StrUtils,Classes;
    var rub:byte;
    function SumToString(Value : String) : string;//Сумма прописью
    function KolToStrin(Value : String) : string;//Количество прописью
    function padeg(s:string):string;//Склоняет фамилию имя и отчество (кому)
    function padegot(s:string):string;//Склоняет фамилию имя и отчество (от кого)
    function fio(s:string):string;//фамилия имя и отчество сокращенно
    function longdate(s:string):string;//Длинная дата
    procedure getfullfio(s:string;var fnam,lnam,onam:string);//Получить из строки фамилию имя и отчество сокращенно
     
    implementation
    const a:array[0..8,0..9] of string=(
    ('','один ','два ','три ','четыре ','пять ','шесть ','семь ','восемь ','девять '),
    ('','','двадцать ','тридцать ','сорок ','пятьдесят ','шестьдесят ','семьдесят ','восемьдесят ','девяносто '),
    ('','сто ','двести ','триста ','четыреста ','пятьсот ','шестьсот ','семьсот ','восемьсот ','девятьсот '),
    ('тысяч ','одна тысяча ','две тысячи ','три тысячи ','четыре тысячи ','пять тысяч ','шесть тысяч ','семь тысяч ','восемь тысяч ','девять тысяч '),
    ('','','двадцать ','тридцать ','сорок ','пятьдесят ','шестьдесят ','семьдесят ','восемьдесят ','девяносто '),
    ('','сто ','двести ','триста ','четыреста ','пятьсот ','шестьсот ','семьсот ','восемьсот ','девятьсот '),
    ('миллионов ','один миллион ','два миллиона ','три миллиона ','четыре миллиона ','пять миллионов ','шесть миллионов ','семь миллионов ','восемь миллионов ','девять миллионов '),
    ('','','двадцать ','тридцать ','сорок ','пятьдесят ','шестьдесят ','семьдесят ','восемьдесят ','девяносто '),
    ('','сто ','двести ','триста ','четыреста ','пятьсот ','шестьсот ','семьсот ','восемьсот ','девятьсот '));
    c:array[0..8,0..9] of string=(
    ('','одна ','две ','три ','четыре ','пять ','шесть ','семь ','восемь ','девять '),
    ('','','двадцать ','тридцать ','сорок ','пятьдесят ','шестьдесят ','семьдесят ','восемьдесят ','девяносто '),
    ('','сто ','двести ','триста ','четыреста ','пятьсот ','шестьсот ','семьсот ','восемьсот ','девятьсот '),
    ('тысячь ','одна тысяча ','две тысячи ','три тысячи ','четыре тысячи ','пять тысяч ','шесть тысяч ','семь тысяч ','восемь тысяч ','девять тысяч '),
    ('','','двадцать ','тридцать ','сорок ','пятьдесят ','шестьдесят ','семьдесят ','восемьдесят ','девяносто '),
    ('','сто ','двести ','триста ','четыреста ','пятьсот ','шестьсот ','семьсот ','восемьсот ','девятьсот '),
    ('миллионов ','один миллион ','два миллиона ','три миллиона ','четыре миллиона ','пять миллионов ','шесть миллионов ','семь миллионов ','восемь миллионов ','девять миллионов '),
    ('','','двадцать ','тридцать ','сорок ','пятьдесят ','шестьдесят ','семьдесят ','восемьдесят ','девяносто '),
    ('','сто ','двести ','триста ','четыреста ','пятьсот ','шестьсот ','семьсот ','восемьсот ','девятьсот '));
    b:array[0..9] of string=
    ('десять ','одинадцать ','двенадцать ','тринадцать ','четырнадцать ','пятнадцать ','шестнадцать ','семнадцать ','восемнадцать ','девятнадцать ');
    var pol:boolean;
     
    function longdate(s:string):string;//Длинная дата
    var
      Pr: TDateTime;
      Y,M,D: Word;
     begin
      Pr:= strtodate(s);
      DecodeDate(Pr,Y,M,D);
      case m of
            1:s:='Января';
            2:s:='Февраля';
            3:s:='Марта';
            4:s:='Апреля';
            5:s:='Мая';
            6:s:='Июня';
            7:s:='Июля';
            8:s:='Августа';
            9:s:='Сентября';
           10:s:='Октября';
           11:s:='Ноября';
           12:s:='Декабря';
      end;
      result:=inttostr(d)+' '+s+' '+inttostr(y)
    end;
     
    function SumToStrin(Value : String) : string;
    var s,t:string;
        p,pp,i,k:integer;
    begin
            s:=value;
            if s='0' then t:='Ноль ' else begin
            p:=length(s);
            pp:=p;
            if p>1 then
            if (s[p-1]='1') and (s[p]>='0') then begin
            t:=b[strtoint(s[p])];pp:=pp-2;end;
            i:=pp;
            while i>0 do begin
            if (i=p-3) and (p>4) then
            if s[p-4]='1' then begin
            t:=b[strtoint(s[p-3])]+'тысяч '+t;i:=i-2;end;
            if (i=p-6) and (p>7) then
            if s[p-7]='1' then begin
            t:=b[strtoint(s[p-6])]+'миллионов '+t;
            i:=i-2;end;
            if i>0 then begin k:=strtoint(s[i]);
            t:=a[p-i,k]+t;
            i:=i-1;end;
            end;end;
            result:=t;
    end;
     
    function kolToStrin(Value : String) : string;
    var s,t:string;
        p,pp,i,k:integer;
    begin
            s:=value;
            if s='0' then t:='Ноль ' else begin
            p:=length(s);
            pp:=p;
            if p>1 then
            if (s[p-1]='1') and (s[p]>'0') then begin
            t:=b[strtoint(s[p])];pp:=pp-2;end;
            i:=pp;
            while i>0 do begin
            if (i=p-3) and (p>4) then
            if s[p-4]='1' then begin
            t:=b[strtoint(s[p-3])]+'тысяча '+t;i:=i-2;end;
            if (i=p-6) and (p>7) then
            if s[p-7]='1' then begin
            t:=b[strtoint(s[p-6])]+'миллионов '+t;
            i:=i-2;end;
            if i>0 then begin k:=strtoint(s[i]);
            t:=c[p-i,k]+t;
            i:=i-1;end;
            end;end;
            result:=t;
    end;
     
    procedure get2str(value:string;var hi,lo:string);
    var p:integer;
    begin
            p:=pos(',',value);
            lo:='';hi:='';
            if p=0 then p:=pos('.',value);
            if p<>0 then delete(value,p,1);
            if p=0 then begin hi:=value;lo:='00';exit;end;
            if p>length(value) then begin hi:=value;lo:='00';exit;end;
            if p=1 then begin hi:='0';lo:=value;exit;end;
            begin
            hi:=copy(value,1,p-1);
            lo:=copy(value,p,length(value));
            if length(lo)<2 then lo:=lo+'0';
            end;
    end;
     
    function sumtostring(value:string):string;
    var hi,lo,valut,loval:string;
        pr,er:integer;
    begin
            get2str(value,hi,lo);
            if (hi='') or (lo='') then begin result:='';exit;end;
            val(hi,pr,er);if er<>0 then begin result:='';exit;end;
            if rub=0 then begin
            if hi[length(hi)]='1' then valut:='рубль ';
            if (hi[length(hi)]>='2') and (hi[length(hi)]<='4') then valut:='рубля ';
            if (hi[length(hi)]='0') or (hi[length(hi)]>='5') or
            ((strtoint(copy(hi,length(hi)-1,2))>10) and (strtoint(copy(hi,length(hi)-1,2))<15)) then valut:='рублей ';
            if (lo[length(lo)]='0') or (lo[length(lo)]>='5') then loval:=' копеек';
            if lo[length(lo)]='1' then loval:=' копейка';
            if (lo[length(lo)]>='2') and (lo[length(lo)]<='4') then loval:=' копейки';
            end
            else begin
            if (hi[length(hi)]='0') or (hi[length(hi)]>='5') then valut:='долларов ';
            if hi[length(hi)]='1' then valut:='доллар ';
            if (hi[length(hi)]>='2') and (hi[length(hi)]<='4') then valut:='доллара ';
            if (lo[length(lo)]='0') or (lo[length(lo)]>='5') then loval:=' центов';
            if lo[length(lo)]='1' then loval:=' цент';
            if (lo[length(lo)]>='2') and (lo[length(lo)]<='4') then loval:=' цента';
            end;
            hi:=sumtostrin(inttostr(pr))+valut;
            if lo<>'00' then begin
            val(lo,pr,er);if er<>0 then begin result:='';exit;end;
            lo:=inttostr(pr);
            end;
            if length(lo)<2 then lo:='0'+lo;
            lo:=lo+loval;
            hi[1]:=AnsiUpperCase(hi[1])[1];
            result:=hi+lo;
    end;
     
    function pfam(s:string):string;
    begin
            if (s[length(s)]='к') or(s[length(s)]='ч') and (pol=true) then s:=s+'у';
            if s[length(s)]='в' then s:=s+'у';
            if s[length(s)]='а' then begin delete(s,length(s),1);
            result:=s+'ой';exit;end;
            if s[length(s)]='н' then s:=s+'у';
            if s[length(s)]='й' then begin delete(s,length(s)-1,2);
            result:=s+'ому';end;
            if s[length(s)]='я' then begin delete(s,length(s)-1,2);
            result:=s+'ой';exit;end;
            result:=s;
    end;
     
    function pnam(s:string):string;
    begin
            pol:=true;
            if s[length(s)]='й' then begin delete(s,length(s),1);
            s:=s+'ю';end;
            if s[length(s)]='л' then s:=s+'у';
            if s[length(s)]='р' then s:=s+'у';
            if s[length(s)]='м' then s:=s+'у';
            if s[length(s)]='н' then s:=s+'у';
            if s[length(s)]='я' then begin pol:=false;delete(s,length(s),1);
            s:=s+'е';end;
            if s[length(s)]='а' then begin pol:=false;delete(s,length(s),1);
            s:=s+'е';end;
            result:=s;
    end;
     
    function potch(s:string):string;
    begin
            if s[length(s)]='а' then begin delete(s,length(s),1);
            s:=s+'е';end;
            if s[length(s)]='ч' then s:=s+'у';
            result:=s;
    end;
     
    function ofam(s:string):string;
    begin
            if (s[length(s)]='к') or(s[length(s)]='ч') and (pol=true) then s:=s+'а';
            if s[length(s)]='а' then begin delete(s,length(s),1);
            result:=s+'ой';exit;end;
            if s[length(s)]='в' then s:=s+'а';
            if s[length(s)]='н' then s:=s+'а';
            if s[length(s)]='й' then begin delete(s,length(s)-1,2);
            result:=s+'ова';end;
            if s[length(s)]='я' then begin delete(s,length(s)-1,2);
            result:=s+'ой';exit;end;
            result:=s;
    end;
     
    function onam(s:string):string;
    begin
            pol:=true;
            if s[length(s)]='а' then if s[length(s)-1]='г' then
            begin pol:=false;delete(s,length(s),1);
            s:=s+'и';end else
            begin pol:=false;delete(s,length(s),1);
            s:=s+'ы';end;
            if s[length(s)]='л' then s:=s+'а';
            if s[length(s)]='р' then s:=s+'а';
            if s[length(s)]='м' then s:=s+'а';
            if s[length(s)]='н' then s:=s+'а';
            if s[length(s)]='я' then begin pol:=false;delete(s,length(s),1);
            s:=s+'и';end;
            if s[length(s)]='й' then begin delete(s,length(s),1);
            s:=s+'я';end;
            result:=s;
    end;
     
    function ootch(s:string):string;
    begin
            if s[length(s)]='а' then begin delete(s,length(s),1);
            s:=s+'ы';end;
            if s[length(s)]='ч' then s:=s+'а';
            result:=s;
    end;
     
    function padeg(s:string):string;
    var q:tstringlist;
        p:integer;
    begin
            if s<>'' then begin
            q:=tstringlist.Create;
            p:=pos(' ',s);
            if p=0 then p:=pos('.',s);
            if p=0 then q.Add(s) else begin
            q.Add(copy(s,1,p-1));
            delete(s,1,p);
            p:=pos(' ',s);
            if p=0 then p:=pos('.',s);
            if p=0 then q.Add(s) else begin
            q.Add(copy(s,1,p-1));
            delete(s,1,p);
            p:=pos(' ',s);
            if p=0 then p:=pos('.',s);
            if p=0 then q.Add(s) else begin
            q.Add(copy(s,1,p-1));
            delete(s,1,p);end;
            end;end;
            if q.Count>1 then result:=result+' '+pnam(q[1]);
            if q.Count>0 then result:=pfam(q[0])+result;
            if q.Count>2 then result:=result+' '+potch(q[2]);
            q.Free;
            end;
    end;
     
    function fio(s:string):string;
    var q:tstringlist;
        p:integer;
    begin
            if s<>'' then begin
            q:=tstringlist.Create;
            p:=pos(' ',s);
            if p=0 then p:=pos('.',s);
            if p=0 then q.Add(s) else begin
            q.Add(copy(s,1,p-1));
            delete(s,1,p);
            p:=pos(' ',s);
            if p=0 then p:=pos('.',s);
            if p=0 then q.Add(s) else begin
            q.Add(copy(s,1,1));
            delete(s,1,p);
            p:=pos(' ',s);
            if p=0 then p:=pos('.',s);
            if p=0 then q.Add(copy(s,1,1)) else begin
            q.Add(copy(s,1,1));
            end;
            end;end;
            if q.Count>1 then result:=q[0]+' '+q[1]+'.';
            if q.Count>2 then result:=result+q[2]+'.';
            q.Free;
            end;
    end;
     
    function padegot(s:string):string;
    var q:tstringlist;
        p:integer;
    begin
            if s<>'' then begin
            q:=tstringlist.Create;
            p:=pos(' ',s);
            if p=0 then p:=pos('.',s);
            if p=0 then q.Add(s) else begin
            q.Add(copy(s,1,p-1));
            delete(s,1,p);
            p:=pos(' ',s);
            if p=0 then p:=pos('.',s);
            if p=0 then q.Add(s) else begin
            q.Add(copy(s,1,p-1));
            delete(s,1,p);
            p:=pos(' ',s);
            if p=0 then p:=pos('.',s);
            if p=0 then q.Add(s) else begin
            q.Add(copy(s,1,p-1));
            delete(s,1,p);end;
            end;end;
            if q.Count>1 then result:=result+' '+onam(q[1]);
            if q.Count>0 then result:=ofam(q[0])+result;
            if q.Count>2 then result:=result+' '+ootch(q[2]);
            q.Free;
            end;
    end;
     
    procedure getfullfio(s:string;var fnam,lnam,onam:string);//Получить из строки фамилию имя и отчество сокращенно
    begin
        fnam:='';lnam:='';onam:='';
        fnam:=copy(s,1,pos(' ',s));
        delete(s,1,pos(' ',s));
        lnam:=copy(s,1,pos(' ',s));
        delete(s,1,pos(' ',s));
        onam:=s;
    end;
     
    begin
    rub:=0;
    end. 

Пример использования:

    s:=SumToString('123.00'); 
