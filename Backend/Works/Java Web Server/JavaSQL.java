/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.abdis.rest;

import java.sql.*;
/**
 *
 * @author Abdis
 */
public class SQL {
    
    public SQL()
    {
        
    }
    
    public String Register(String username, String Password) {      
        
        try
        {
        // create a mysql database connection
            String myDriver = "org.gjt.mm.mysql.Driver";
            String myUrl = "jdbc:mysql://localhost:3306/user";
            Class.forName(myDriver);
            Connection conn = DriverManager.getConnection(myUrl, "root", "");
      
            Statement st = conn.createStatement();
            
            ResultSet result = st.executeQuery("SELECT * FROM cowboy where name='"+username+"'");
            if (result.isBeforeFirst() )
                return "user telah terdaftar";
            
            
            st.executeUpdate("INSERT INTO cowboy (user_id, name, password) "
                    +"VALUES ('u133', '"+username+"', '"+Password+"')");
            
           
            
            conn.close();
           return "sukses Daftar";
        }
        catch (Exception e)
        {
            System.out.println(e.getMessage());
            return "Gagal Daftar";
        }
       
    }
}