---
Title: Метод Дихотомии
Date: 01.01.2007
---


Метод Дихотомии
===============

    program dicotomie;
    var y:integer;
    function f(var x:real):real;
     
    begin
    if y=1 then f:=sin(x)-1/2
           else begin if y=2 then f:=exp(x)-2
                             else begin if y=3 then f:=sqr(x)-2 end; end;
    end;
    procedure verif;
    var a,b,m,ep,va:real;
        i,n:integer;
        r,c:char;
    begin  repeat
       writeln('choisir une fonction parmis les trois');
       writeln('f[x]=sin(x)-1/2.....[1]');
       writeln('f[x]=exp(x)-2.......[2] ');
       writeln('f[x]=x(puiss)2-2....[3] ');
       write('entrer le nombre [i] de 1..3 i=');
       readln(y);
       writeln('pour calculer la racine de la fonction f[x] donne  lintervalle [a,b]') ; 
       write('                      donner a=');
       readln(a);
       write('                      donner b=');
       readln(b);begin
                 if a>b then
                   repeat writeln('*****************REMARQUE**************');
     writeln('                       *** il faut que a<b ***     ');
     write('S.V.P entrer un autre intervalle ou invercer les valeurs a=');
                          readln(a);
                          write('                                                         b=');
                          readln(b);
                   until a<b;
       begin
         if f(a)*f(b)>0  then
           repeat
             writeln('*******************REMARQUE************************');
    writeln('  *** la fonction ne admet aucun zero dans se intervalle *** ');
    writeln('     ');
             write('S.V.P entrer un autre intervalle a=');
             readln(a);
             write('                                 b=');
             readln(b);
           until f(a)*f(b)<=0;
             writeln('la fonctin f admet au moins un zero dans [',a,';',b,']');
             write('                ');
             write('entrer le nombre d"iteration n=');
             readln(n);
               m:=(a+b)/2; if f(m)=0  then  ep:=m
                                 else
                                  begin  for i:=1 to n-1 do
                                   begin   if f(m)*f(a)>0 then begin a:=m; m:=(b+m)/2;   end
                                                                else  m:=(a+m)/2; b:=2*m-a;
                                                                     end;
                                         end; i:=i+1;
                                              ep:=m;
                        writeln('   la RACINE pour l"iteration ',n,' est epsilon=',ep);
                        write('voulez vous calculerf[',ep,'] O/N?');
                        readln(c); if c='O' then writeln('f[',ep,']=',f(ep));
           write('voulez vous continuer O/N? ');
           readln(r);    end;      end;
      until r='N';
     
     
    end;
     
    begin
       writeln('                           DICOTOMIE                                ');
       writeln('       ');
     
       writeln('              ');
         verif;
     
    end.
