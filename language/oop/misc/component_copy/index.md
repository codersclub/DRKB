---
Title: Как создать копию (клон) произвольного компонента?
Date: 01.01.2007
---


Как создать копию (клон) произвольного компонента?
===========================================

    { 
     Здесь пpоцедypа CreateClone, котоpая кpеатит компонентy ОЧЕHЬ ПОХОЖУЮ на 
     входнyю. С такими же значениями свойств.
     Пpисваивается все, кpоме методов. 
    } 
    function CreateClone(Src: TComponent): TComponent; 
    var 
      F: TStream; 
    begin 
      F := nil; 
      try 
        F := TMemoryStream.Create; 
        F.WriteComponent(Src); 
        RegisterClass(TComponentClass(Src.ClassType)); 
        F.Position := 0; 
        Result := F.ReadComponent(nil); 
      finally 
        F.Free; 
      end; 
    end; 
