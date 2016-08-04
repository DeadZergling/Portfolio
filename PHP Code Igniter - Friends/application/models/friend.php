<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class friend extends CI_Model
{ 
	function getUserInfo($id)
	{
		$query = "SELECT users.id, users.name, users.alias, users.email FROM users WHERE users.id = ?";
		return $this->db->query($query,intval($id))->row();
	}
	function getUserRow($email)
	{
		$query = "SELECT users.id, users.name, users.alias, users.email, users.password FROM users WHERE users.email = ?";
		return $this->db->query($query,$email)->row();
	}
	function insertNewUser($post)
	{
		$query = "INSERT INTO users (name, alias, email, password, date_of_birth, created_at, updated_at) VALUES (?,?,?,?,?,NOW(),NOW())";
		$array = array($post['name'], $post['alias'], $post['email'], $post['password'], $post['date_of_birth']);
		$this->db->query($query,$array);
	}
	function getMyFriends($id)
	{
		$query = "SELECT users2.id as friend_id, users2.alias as friend_alias FROM users LEFT JOIN friendships ON (users.id = friendships.friend1_id OR users.id = friendships.friend2_id) LEFT JOIN users as users2 ON (friendships.friend1_id = users2.id OR friendships.friend2_id = users2.id)  WHERE users2.id != users.id AND users.id = ?";
		return $this->db->query($query,$id)->result_array();
	}
	function getnotFriends($id)
	{
		$query = "SELECT users.id as friend_id, users.alias as friend_alias FROM users WHERE users.id != ?";
		return $this->db->query($query,$id)->result_array();
	}
	function addFriend($id)
	{
		$query = "SELECT * FROM friendships WHERE (friend1_id = ? AND friend2_id = ?) OR (friend1_id = ? AND friend2_id = ?)";
		$array = array($id, intval($this->session->userdata('id')), intval($this->session->userdata('id')), $id);
		if($this->db->query($query,$array)->row() == null)
		{
			$query = "INSERT INTO friendships (friend1_id, friend2_id, created_at, updated_at) VALUES (?, ?, NOW(), NOW())";
			$this->db->query($query, array($id, intval($this->session->userdata('id'))));
		}
	}
	function removeFriend($id)
	{
		$query = "DELETE FROM friendships WHERE (friend1_id = ? AND friend2_id = ? OR friend2_id = ? AND friend1_id = ?)";
		$array = array($id, $this->session->userdata('id'), $this->session->userdata('id'), $id);
		$this->db->query($query,$array);
	}
	// function getMyWishList($id)
	// {
	// 	$query = "SELECT wish_items.id as wish_item_id, wish_items.name as wish_item_name,  users2.name as added_by_name, users2.id as added_by_id, wish_items.created_at as wish_item_create_date FROM users LEFT JOIN users_has_wish_items  ON users.id = users_has_wish_items.user_id LEFT JOIN wish_items ON users_has_wish_items.wish_item_id = wish_items.id LEFT JOIN users as users2  ON wish_items.user_id = users2.id WHERE users.id = ? ORDER BY wish_items.created_at ASC";
	// 	return $this->db->query($query, $id)->result_array();
	// }

	// function getOthersWishList($id)
	// {
	// 	$query = "SELECT wish_items.id as wish_item_id, wish_items.name as wish_item_name,  users2.name as added_by_name, users2.id as added_by_id, wish_items.created_at as wish_item_create_date FROM users LEFT JOIN users_has_wish_items  ON users.id = users_has_wish_items.user_id LEFT JOIN wish_items ON users_has_wish_items.wish_item_id = wish_items.id LEFT JOIN users as users2  ON wish_items.user_id = users2.id WHERE users.id != ? AND wish_item_id is not null GROUP BY wish_item_name ORDER BY wish_items.created_at ASC";
	// 	return $this->db->query($query, $id)->result_array();
	// }

	// function getItemView($id)
	// {
	// 	$query = "SELECT wish_items.id as wish_item_id, wish_items.name as wish_item_name,  users.name as user_name FROM users LEFT JOIN users_has_wish_items  ON users.id = users_has_wish_items.user_id LEFT JOIN wish_items ON users_has_wish_items.wish_item_id = wish_items.id WHERE wish_items.id = ?";
	// 	return $this->db->query($query, $id)->result_array();
	// }

	// function insertNewItem($post)
	// {
	// 	$query = "SELECT wish_items.name FROM wish_items WHERE wish_items.name = ?";
	// 	$check = $this->db->query($query, $post)->row();
	// 	if($check == null)
	// 	{
	// 		$query = "INSERT INTO wish_items (name, created_at, updated_at, user_id) VALUES(?,NOW(),NOW(),?)";
	// 		$this->db->query($query, array($post, $this->session->userdata('id')));
	// 		$query = "INSERT INTO users_has_wish_items (user_id, wish_item_id) VALUES (?,?)";
	// 		return $this->db->query($query, array(intval($this->session->userdata('id')), $this->db->insert_id()));
	// 	}
	// }

	// function addToWishList($post)
	// {
	// 	$query = "SELECT * FROM users_has_wish_items WHERE users_has_wish_items.user_id = ? AND users_has_wish_items.wish_item_id = ?";
	// 	$array = array($this->session->userdata['id'], $post);
	// 	$check = $this->db->query($query, $array)->row();
	// 	if($check == null)
	// 	{
	// 		$query = "INSERT INTO users_has_wish_items (user_id, wish_item_id) VALUES (?,?)";
	// 		return $this->db->query($query, array(intval($this->session->userdata('id')), $post));
	// 	}
	// }

	// function removeFromWishList($post)
	// {
	// 	$query = "DELETE FROM users_has_wish_items WHERE users_has_wish_items.wish_item_id = ? AND users_has_wish_items.user_id = ?";
	// 	$this->db->query($query, array($post, $this->session->userdata('id')));
	// 	$query = "SELECT * FROM users_has_wish_items WHERE users_has_wish_items.wish_item_id = ?"; //ultimately pointless
	// 	$check = $this->db->query($query, $post);
	// 	if($check == null)
	// 	{
	// 		return $this->deleteWishItem($post);
	// 	}
	// 	return;
	// }
	
	// function deleteWishItem($post)
	// {
	// 	$query = "DELETE FROM users_has_wish_items WHERE users_has_wish_items.wish_item_id = ?";
	// 	$this->db->query($query, $post);
	// 	$query = "DELETE FROM wish_items WHERE wish_items.id = ?";
	// 	$this->db->query($query, $post);		
	// }
}
 ?>