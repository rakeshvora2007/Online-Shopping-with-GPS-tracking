<%@page import="com.util.CartDetails"%>
<%@page contentType="text/html" pageEncoding="UTF-8"%>
<%@page import ="com.util.ProductDetails" %>
<%@page import="java.util.ArrayList" %>
<%@page import="java.util.HashMap" %>
<%@page import="com.util.Query" %>
<%
    response.setHeader("Cache-Control", "no-store"); //when you hit back, it displays "Confirm page Submission"
    response.setHeader("Pragma", "no-cache");
    response.setDateHeader("Expires", 0);
%>
<!--%! String ifnull(String s){          You could use this, if the String ever goes null
    return (s==null)?\"\":s;
}
%-->
<%@ page errorPage="error.jsp"%>

<%!  ProductDetails pro = new ProductDetails();  //instantiating ProductDetails class and calling the getter mthods.
    CartDetails mycart = new CartDetails();
    ProductDetails sessionbean = new ProductDetails();  //need to remove 
    String name = null;
    //name = (String) request.getAttribute("name");  // very much needed line. use setters and getters instead of this.
    ArrayList productname = new ArrayList();
    ArrayList productdescription = new ArrayList();
    ArrayList brandname = new ArrayList();
    ArrayList productprice = new ArrayList();
    Query queryObject = new Query();
    //ProductDetails productdetailsObject = queryObject.getProductDetails();   need to comment it if you need to get the object from..

    //getAttribute and setAttribute always works
%>
<%
    productname = (ArrayList) session.getAttribute("productname");
    productdescription = (ArrayList) session.getAttribute("productdescription");
    brandname = (ArrayList) session.getAttribute("brandname");
    productprice = (ArrayList) session.getAttribute("productprice");
    System.out.println("Product DESCRIPTION SET IN USER CART.JSP");
    sessionbean.setProduct_description( productdescription );
//    out.println("productdetailsObject values name = " + productdetailsObject.getProduct_name());  
//    out.println("productdetailsObject values name = " + productdetailsObject.getProduct_description());
//    out.println("productdetailsObject values name = " + productdetailsObject.getProduct_price());
//    out.println("productdetailsObject values name = " + productdetailsObject.getProduct_brand());
%>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="vijays_shop.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="css/bootstrap-responsive.css">
        <script type="text/javascript" src="js/jquery-1.11.2.js"></script>
        <script type="text/javascript" src="js/bootstrap.js"></script>
        <title>JSP Page</title>
    </head>
    <body>
        <script type="text/javascript">
        
            function changeImage()
            {
                element=document.getElementById('myimage');
                
                //                itemid=document.getElementbyId('myimage');
                //                alert(itemid.id);
                
                if (element.src.match("Images/image_3.gif"))
                {
                    element.src="Images/image_1.jpg";
                }
                else if(element.src.match("Images/image_1.jpg"))
                {
                    element.src="Images/image_2.jpg";
                }
                else 
                {
                    element.src="Images/image_3.gif";
                }
            }    
        </script>
        <div class="row">
            <div class="col-lg-12">
                <img style="width: 70%;" src="Images/logo.jpg" />
            </div>
        </div>
        <% String authentication = (String) session.getAttribute("authentication");
            if (authentication == null) {
                request.getRequestDispatcher("/index.jsp").forward( request, response );
        %>
        
        <!--jsp:useBean id="name" scope="session" class="com.util.Controller"--><!--/jsp:useBean-->        
        <div id="login_in">
            <form name="Home_Page" action="Controller" method="Post">
                <div align="right">                       
                    Username    <input  type="text" maxlength="40" name="login_name"> &nbsp;&nbsp;
                    Password    <input type="password" maxlength="40" name="login_password">             
                    <input type="submit" name="login_submit" value="Submit" onclick="check();">             
                    <a href="registration.jsp"> Register </a>
                </div>                    
            </form>
            <% }
                if ( authentication != null ) {
                    if ( authentication.equals( "Auth_Success" ) ) {
            %>
            <form name="logout" action="Controller" method="Post">
                 <div style="position: absolute; top:5px; right: 5px;" class="logmeout"> <input class="btn btn-primary btn-md" type="submit" name="signout" value=" Logout "> </div>
            </form>         
            <%} else {%>
            <div id="wrong_user"> <span style="color:red"> Username/Password is wrong! </span> </div>
            <form name="Home_Page" action="Controller" method="Post">
                <div id="login_in" align="right">                       
                    Username    <input  type="text" maxlength="40" name="login_name"> &nbsp;&nbsp;
                    Password    <input type="password" maxlength="40" name="login_password">             
                    <input type="submit" name="login_submit" value="Submit" onclick="check();">             
                    <a href="registration.jsp"> Register </a>
                </div>                    
            </form>

            <%}
                }%>

        </div>  
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 bg-white box-shadow-common round-border10">
                <table class="table">
                    <tr>
                        <td class="navbar1"><a href="#">Home</a></td>
                        <td class="navbar1"><a href="#">Products</a></td>
                        <td class="navbar1"><a href="#">Services</a></td>
                        <td class="navbar1"><a href="#">Contact</a></td>
                    </tr>
                </table>
                <div class="col-lg-12">
                    <form name="cart" action="Controller" method="Post">
                        <select name="Item">
                            <option value="books"> Books </option>
                            <option value="electronics"> Electronics </option>
                            <option value="icecream"> Ice Cream </option>
                        </select>
                        <input class="btn btn-primary btn-sm" type="submit" value="View Products" name="product">
                    </form>
                    <% if ( productname != null ) {%> 
                    <form name="cart_details" method="Post" action="Controller">
                        <span id="Finish_n_checkout"> <input class="btn btn-md btn-success" type="submit" value="Checkout" name="checkout_cart"> </span>    
                        <% if (session.getAttribute("total_cart_items") != null) {%>
                        <table class="table" style="background: #eee;">
                            <tr><td align="center" colspan="2"><h2 class="text-center">Shopping Kart</h2></td></tr>
                            <tr>
                                <td rowspan="2"><img src="Images/kart.png" height="70" /></td>
                                <td><h4>Total items in cart</h4></td>
                            </tr>
                            <tr>
                                <td>
                                    <b><%= session.getAttribute("total_cart_items")%></b>
                                </td>
                            </tr>
                        </table>
                            
                        <% }%>
                        <%        for (int i = 1; i <= productname.size(); i++) {
                            %> 

                        <article id="inner_article">                      
                            <table class="table" cellspacing="0" cellpadding="0" border="1>
                                <br /> 
                                <tr>
                                    <td id="table_data"> <%= i%> . 
                                        <img id="myimage"  onclick="changeImage()" border="0" src="Images/image_3.gif" width="75" height="75" alt="Loading..">
                                        <span id="inner_artcile_heading" > <%= productname.get(i - 1)%> </span> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; </td>
                                    <td align="right">
                                        <span> Qty <input type="text" name="quantity" value="" size="1"> </span>
                                        <span> <input type="submit" class="btn btn-primary btn-sm" value="Add to Cart" name="cartdetails"> </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td id="table_data"> by 
                                        <span id="inner_artcile_dealer"> <%= brandname.get(i - 1)%> </span> <br> 
                                    </td>
                                </tr>
                                <tr><td id="table_data"> <%= productdescription.get(i - 1)%> <br>  </td></tr>
                                <tr><td id="table_data"> Price: $<%= productprice.get(i - 1)%> <br>  </td></tr>                                
                            </table>
                        </article>

                        <%
                            }%>
                        <% session.setAttribute("product_name", productname);
                            }%>                            

                    </form>
                </div>
            </div>
            
        </div>
        
    </body>
</html>