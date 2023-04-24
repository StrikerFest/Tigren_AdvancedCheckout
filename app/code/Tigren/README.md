# Exercise 1:

## Create a  new product attribute and name it "Allow multi-order"

- Create

![image](https://user-images.githubusercontent.com/72716233/233884568-8aaf067e-938f-4a1b-aa61-20006606a116.png)

![image](https://user-images.githubusercontent.com/72716233/233884929-b63fe5e4-f959-413a-b15c-c2a4e5fa0cd5.png)

![image](https://user-images.githubusercontent.com/72716233/233884990-39db8ece-cd53-4a32-821a-49d07c11a760.png)

![image](https://user-images.githubusercontent.com/72716233/233885116-0930f1ac-9e1c-453c-b209-08f8965beae8.png)

## When customer click adds to cart

- In this scenario
    - Le Light body bag's allow multi-order is no
    - Le NFT monkey body bag's allow multi order is yes

### Case 1: If allow_multi_order is No, and existing product is in the cart

- Popup have two buttons:

![image](https://user-images.githubusercontent.com/72716233/233885513-8f041320-f910-4041-8987-87c909dd5601.png)

![image](https://user-images.githubusercontent.com/72716233/233885557-60088724-6d1d-4456-8801-4531d955d76f.png)

- Proceed to checkout: Redirect to the checkout page

![image](https://user-images.githubusercontent.com/72716233/233885606-79db2ce7-b9f8-492a-bfc5-784cab703d4c.png)

- Clear cart: Remove all items from cart

![image](https://user-images.githubusercontent.com/72716233/233885660-d993e501-89b2-4318-a4bf-13891cf1e932.png)

### Case 2: If allow_multi_order is No, and Cart is empty

![image](https://user-images.githubusercontent.com/72716233/233885734-755d1073-7dac-4383-8945-341adb27d6ad.png)

### Case 3: If allow_multi_order is Yes

![image](https://user-images.githubusercontent.com/72716233/233885771-6b7768d9-8d4c-4464-83f5-36cf65643edf.png)

## When customer place order when they have pending order

![image](https://user-images.githubusercontent.com/72716233/233885906-6a129891-463d-4115-97a5-a0c11da7c98c.png)

![image](https://user-images.githubusercontent.com/72716233/233886280-8d629160-ed91-4ba2-9177-a3119cb10cb6.png)

## When guest create an order. Create a customer account with the shipping address in the filled form

![image](https://user-images.githubusercontent.com/72716233/233886516-3660fa78-bce8-4afa-bbc5-bc479d9b1e04.png)

![image](https://user-images.githubusercontent.com/72716233/233886814-b446fd0e-dff8-4aa7-8cbc-a718abaf7304.png)

![image](https://user-images.githubusercontent.com/72716233/233887098-38669ae6-8fd2-465e-b632-ed3ecb6a3506.png)

![image](https://user-images.githubusercontent.com/72716233/233887253-5b75169b-7ba6-4359-8a5e-40958c382c44.png)

## Third party needs a rest API to support customer  login in the Magento system. Create a new rest API to support

![image](https://user-images.githubusercontent.com/72716233/233887614-13f3cbf8-00e0-40b6-b1da-64b3ebbea62c.png)

# Exercise 2:

## Backend Configuration

### Set Delivery date and time config

![image](https://user-images.githubusercontent.com/72716233/233888110-63d09b95-51f9-4a2b-ae37-f85167c20c77.png)

## Frontend Interaction

### Display delivery data field

![image](https://user-images.githubusercontent.com/72716233/233888503-ca99782a-d811-40fd-a1e5-48f6c39f6603.png)

- Date in the past, configuration's days in the week (Saturday, Sunday) and dates in the month (28th April) is excluded

### Show delivery time to order

#### Frontend detail

##### Ordering

![image](https://user-images.githubusercontent.com/72716233/233888710-5dae68b1-d0f1-4fce-84a7-dd2484e1d652.png)

##### Order detail history

![image](https://user-images.githubusercontent.com/72716233/233888776-742f84eb-46d6-47b6-874a-83bbf1e46017.png)

#### Backend detail

![image](https://user-images.githubusercontent.com/72716233/233888988-bfa52f44-3b29-48f5-856d-b5a40552ed85.png)


