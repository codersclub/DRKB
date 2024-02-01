---
Title: Как прочитать адрес отправителя?
Date: 01.01.2007
ID: 04443
---


Как прочитать адрес отправителя?
================================


    {
      If you tried to work with messages from Delphi, you know that received message have the
      SenderName property (name of sender) but doesn't allow to read the real address of sender.
      Something like SenderAddress is not available.
     
      There exist a few methods to retrieve this information:
     
      1. help file says that sender is in Recipients collection
      with Type property - 0 (olOriginator).
      But this way does work for any version of MS Outlook.
      So just iterate thru collection of Recipients and find an item with Type=0
      couldn't return required value
     
      2. as alternative you can read a ReplyTo property - there you'll receive an address
      (but generally ReplyTo and Sender could be different).
      For example, in messages which I send from own mail account these values are different.
     
      3. to create a new MailItem (just will be destroyed without saving in end of work),
      define a Recipient as value which you received from SenderName of your original
      message and call a Resolve method - after that you'll recieve a correct email address of this sender.
     
      4. more correct and fast solution is the next:
    }
     
    var
     s: string;
     objCDO: OLEVariant;
    begin
      objCDO := CreateOLEObject('MAPI.Session');
      objCDO.Logon('', '', False, False);
      objMsg := objCDO.GetMessage(itemOL.EntryID, itemOL.Parent.StoreID);
     
      s := objMsg.Sender.Address;
      ShowMessage(s);
      objMsg := Unassigned;
      objCDO := Unassigned;
    end
     
     
    { where itemOL is a MailItem which contain a SenderName but doesn't contain a SenderAddress }
