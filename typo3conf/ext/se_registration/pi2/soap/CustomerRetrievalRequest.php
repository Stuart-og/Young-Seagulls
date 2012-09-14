<?= "<?xml version=\"1.0\" encoding=\"utf-8\"?>" ?>
<CustomerRetrievalRequest> 
  <Version>1.0</Version> 
  <TransactionHeader> 
    <SenderID></SenderID> 
    <ReceiverID></ReceiverID> 
    <CountryCode></CountryCode> 
    <LoginID>YSG1</LoginID> 
    <Password>YSG1</Password> 
    <Company>YSG</Company> 
    <TransactionID></TransactionID> 
  </TransactionHeader> 
 
  <CustomerRetrieval> 
	  <CustomerNo><?=$user['username']?></CustomerNo>   
  </CustomerRetrieval> 
 
</CustomerRetrievalRequest>
