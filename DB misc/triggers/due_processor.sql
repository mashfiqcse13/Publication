/* 
 * This Trigger will Do processing due for each sale
This will be executed after a insert done inf 'puB_memos'
 */
/**
 * Author:  MD. Mashfiq
 * Created: May 5, 2016
 */

begin


SET @total_bill= ( new.sub_total - new.discount- new.book_return ), @balance_recived = ( new.cash + new.bank_pay ) ;
 
IF( @balance_recived > @total_bill) THEN

	INSERT INTO `pub_due_payment_ledger` (`due_payment_ledger_ID`, `memo_ID`, `contact_ID`, `due_payment_amount`, `payment_date`) VALUES (NULL, new.memo_ID, new.contact_ID, ( @balance_recived - @total_bill ), new.issue_date);

END IF;



IF( @balance_recived < @total_bill) THEN

        -- Updating info to the "pub_due_log" table
	INSERT INTO `pub_due_log` (`total_due_ID`, `contact_ID`, `memo_ID`, `due_amount`, `due_date`) VALUES (NULL, new.contact_ID, new.memo_ID, ( @total_bill - @balance_recived), new.issue_date);
	
	
	SELECT  count(*) INTO @entry_exists FROM `customer_due` WHERE `id_customer`=new.contact_ID;
        -- Updating info to the "customer_due" table
	IF(@entry_exists <= 0 )THEN
		INSERT INTO `customer_due`( `id_customer`, `total_due_billed`, `total_paid`, `total_due`) 
		VALUES (new.contact_ID,( @total_bill - @balance_recived),0,( @total_bill - @balance_recived));
	ELSE
                UPDATE `customer_due` SET 
			`total_due_billed` = `total_due_billed` + ( @total_bill - @balance_recived) , 
			`total_due` = `total_due` + ( @total_bill - @balance_recived)
		WHERE `id_customer`=new.contact_ID ;
	END IF;

END IF;

-- Updating info to the "cash" table
IF( new.cash > 0) THEN

    UPDATE `cash` SET 
        `total_in`= `total_in` + new.cash,
        `balance`= `balance` + new.cash 
    WHERE `id_cash`=0

END IF;

end