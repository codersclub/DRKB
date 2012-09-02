<h1>Установка InterBase и добавление пользователя</h1>
<div class="date">01.01.2007</div>


<p class="author">Автор: Denis Alexandrovich Ivanov&nbsp; </p>

<p>Как сделать инсталятор, который прописывал бы пользователя в Interbase? BDE при этом не нужна совсем. </p>

<p>1. При помощи InstallShieldExpress формируется проект, который включает в себя установку Interbase Server.</p>
<p>2. После установки Interbase запускаешь программу, написанную на Delphi 6, которая добавляет нового пользователя Interbase </p>

<pre>
 
 
{************************************************************************
Проект       : ....
Автор        : Иванов Д.А.
Назначение   : Выжимки из библиотеки функций для работы со справочником
               пользователей
               Note: You must install InterBase 6 to use this feature.
Дата создания: 11.13.2002
История      :
************************************************************************}
unit usr;
interface
uses IBCustomDataSet,IBDataBase,IBServices;
type
  TUsrInfo = record
    Usr:string ; //login
    Uid:integer; //уникальный идентификатор, если программа ведет
                 //справочник пользователей в своей БД - его можно
                 //брать оттуда по секвенции
    Grp:integer; //Group
    Pas:string ; //password
  end;
 
  TUsrClass = class(TObject)
  private
    { Private declarations }
  public
    UsrData:TUsrInfo;
    dbSec  :TIBSecurityService;
    // добавляет или редактирует пользователя в Interbase
    function UpdateUser: string;
  end;
 
  TUsrLib = class(TUsrClass)
  private
    { Private declarations }
  public
    procedure AddNewUserToInterbase;
  end;
 
var
  clUsr:TUsrLib;
 
implementation
uses SysUtils,Controls,db,windows,QDialogs;
 
(***************** Добавляет или редактирует пользователя ***************)
function TUsrClass.UpdateUser: string;
                               //Usrid = 0 - новый пользователь
  var Edes:string; //Описание ошибок
begin
  try
    if UsrData.Usr = '' then Edes:= 'не указан login пользователя';
    if UsrData.Uid = 0  then Edes:= 'не указан id пользователя';
    if UsrData.Grp = 0  then Edes:= 'не 
    if UsrData.Pas = '' then Edes:= 'не указан пароль пользователя';
    if EDes &lt; &gt;  '' then raise Exception.Create(Edes);
    //Добавляем пользователя в interbase
    with dbSec do begin
      if not Active then Active := True;
      UserName  := UsrData.Usr;
      UserID    := UsrData.Uid;
      GroupID   := UsrData.Grp;
      Password  := UsrData.Pas;
      try
        DisplayUser(UserName);
        if UserInfo[0] = nil then AddUser else ModifyUser;
      except
        Edes:='Ошибка добавления пользователя в interbase security';
        raise Exception.Create(Edes);
      end;
      //раздача если нужно права доступа пользователя на таблицы
      (* EDes:= GrantData(UsrData.Usr);
         if EDes &lt; &gt;  '' then raise Exception.Create(Edes);
      *)
    end;
  except
    if EDes = '' then EDes:= 'Ошибка добавления пользователя в interbase security';
  end;
  Result:= EDes;
end;
 
procedure TUsrLib.AddNewUserToInterbase;
  var Edes:string; //Описание ошибок
begin
  UsrData.Usr := 'ida' ;
  UsrData.Uid := 123   ;
  UsrData.Grp := 1     ;
  UsrData.Pas := 'pass';
  EDes:= UpdateUser;
  if EDes &lt; &gt;  '' then raise Exception.Create(Edes);
end;
 
begin
  clUsr:=TUsrLib.Create;
end.
</pre>



<p>Установку Interbase 6.0 я пробовал делать двумя системами создания инсталляций: </p>

<p>- InstallShield </p>
<p>- Wise Install Builder. </p>

<p>Для обоих использовал готовые скрипты с сайта http://ibinstall.defined.net/. По результатам могу сказать, что Wise удобнее и проще в инсталляции. Кроме того у него есть текстовый редактор скрипта, что нашему брату шибко нравится. Установка и запуск IBGuard проходит как и в фирменном варианте сразу (Silent Install). </p>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
