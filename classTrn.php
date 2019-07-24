<?php
class medcareTrn extends medcareWallet {
  private $_pdo = null;
	private $_error_message = '';

  public function __construct(PDO $pdo)
  {
      parent::__construct($pdo);
  }

  private function test_user_is_billable($user_uuid, $price){
      //sql request
  }

  private function test_user_has_insurance($user_uuid){
      //sql request
  }

  private function test_user_has_discounts($user_uuid){
    //sql request
  }

  public function testUserIsBillable($user_uuid, $price) {

      return $this->test_user_is_billable($user_uuid, $price);

  }

  private function _insert_trn_in_medcare_wallet($params){

              //sql request
  }

  private function _insert_backed_credits_trn_wallet($params){

              //sql request
  }


    private function _update_trn($id_transaction){
      //sql request
    }

    private function _update_trn_from_insurance($id_transaction){
        //sql request
    }

    private function _update_trn_0($id_transaction){
              //sql request
    }

    private function _update_blocked_amount($params){

                //sql request

    }

    private function _get_amount_from_insurance($params){

              //sql request

    }


  private function get_peyed($consultant_uuid, $user_uuid, $id_reservation,$id){

  //sql request
  }

  public function getPayed($consultant_uuid, $user_uuid, $id_reservation,$id) {
      return $this->get_peyed($consultant_uuid, $user_uuid, $id_reservation,$id);
  }

  private function _peyed_0($consultant_uuid, $user_uuid, $id_reservation){


    //sql request
  }

  public function getPayed_0($consultant_uuid, $user_uuid, $id_reservation) {
      return $this->_peyed_0($consultant_uuid, $user_uuid, $id_reservation);
  }

  private function _save_test_past_reservation($uu_id){

      //sql request
  }

  public function saveTestPastReservation($uu_id) {
      return $this->_save_test_past_reservation($uu_id);
  }

  private function _save_test_past_reservation_insurance($uu_id){

        //sql request
  }

  public function saveTestPastReservationInsurance($uu_id) {
      return $this->_save_test_past_reservation_insurance($uu_id);
  }

  private function _insert_trn($params){
  //sql request
  }

  private function _get_trn_income($uu_id){

              //sql request
  }

  public function getTrnIncome($uu_id) {
      return $this->_get_trn_income($uu_id);
  }

  private function _get_trn_outcome($uu_id){

            //sql request
  }

  public function getTrnOutcome($uu_id) {
      return $this->_get_trn_outcome($uu_id);
  }

  private function _get_request_credits_back(){
      //sql request
  }

  public function getRequestCreditsBack() {
      return $this->_get_request_credits_back();
  }

  private function _get_request_credits_back_id($id){
      //sql request
  }


  private function safe_genarate_trn_reservation($data){
      //sql request
  }


  public function safeGenarateTrnReservation($data) {
      return $this->safe_genarate_trn_reservation($data);
  }


  public function safeGenarateTrnReservationFromInsurance($data) {
      return $this->safe_genarate_trn_reservation_from_insurance($data);
  }

  private function _add_to_medcare_master_wallet($amount,$id,$role)
  {
      //sql request
  }

  public function AddToMedcareMasterWallet($amount,$id,$role)
  {
    return $this->_add_to_medcare_master_wallet($amount,$id,$role);
  }


  private function _add_to_paymet_before_taxes($amount,$id,$role)
  {
    //sql request

  }

  public function AddToPaymentBeforeTaxes($params)
  {
    return $this->_add_to_paymet_before_taxes($params);
  }

  private function _add_to_paymet_insurance($params)
  {
      //sql request
  }

  public function AddToPaymentInsurance($params)
  {
    return $this->_add_to_paymet_insurance($params);
  }

  /*@method for genarate trn from insurance not on mallet */
  private function safe_genarate_trn_reservation_from_insurance($data){

    $today = date("Y-m-d H:i:s");

    $uu_id_user_origin = $data['uu_id_user_origin'];
    $uu_id_user_to = $data['uu_id_user_to'];
    $id_reservation = $data['id_reservation'];
    $transaction_id = $data['transaction_id'];
    $medical_condtion = $data['medical_condtion'];
    $medcare_discounts  = $data['discount_medcare'];
    $medcare_percent_for_medcare = MEDCARE_PARCENT - $medcare_discounts;

    $users_to_tariffs = $this->getUserTarriffs($uu_id_user_to);

    $amount_standart = $users_to_tariffs['amount_standart'];
    $amount_immediate = $users_to_tariffs['amount_immediate'];
    $discount_standart = $users_to_tariffs['discount_standart'];
    $discount_immediate = $users_to_tariffs['discount_immediate'];


    $credits = $this->getsWalletCredits($uu_id_user_origin);

    // $medcare_discounts = $this->test_user_has_discounts($uu_id_user_origin);


    if ($medical_condtion === 'Спешна Консултация') {

      if ($medcare_discounts == 0) {
        $percentage = $discount_immediate;
      } else {
        $percentage = $medcare_discounts;
      }

      $finel_discount = ($percentage / 100) * $amount_immediate;

      $finel_price = $amount_immediate - $finel_discount;

      $is_billable = 1;

      $params = array(
          ':uu_id_user_origin' => $uu_id_user_origin,
          ':uu_id_user_to' => $uu_id_user_to,
          ':id_reservation' => $id_reservation,
          ':id_transaction' => $transaction_id,
          ':is_billable' => $is_billable,
          ':trn_status' => "insurance in progress",
          ':trn_start' => $today,
          ':trn_end' => "",
          ':credits' => $amount_immediate,
          ':amount' => $amount_immediate,
          ':discount_user' => $discount_immediate,
          ':discount_medcare' => $medcare_discounts,
          ':percent_for_medcare' => $medcare_percent_for_medcare,
          ':finel_price' => $finel_price,
          ':payed_from' => 'insurance'
      );

      $this->_insert_trn($params);


    } else {

      if ($medcare_percent === 0) {
        $percentage  =  $discount_standart;
      } else {
        $percentage  =  $medcare_percent;
      }


      $finel_discount = ($percentage / 100) * $amount_standart;

      $finel_price = $amount_standart - $finel_discount;

      $is_billable = $this->test_user_is_billable($uu_id_user_origin, $finel_price);

      $is_billable = 1;

      $params = array(
          ':uu_id_user_origin' => $uu_id_user_origin,
          ':uu_id_user_to' => $uu_id_user_to,
          ':id_reservation' => $id_reservation,
          ':id_transaction' => $transaction_id,
          ':is_billable' => $is_billable,
          ':trn_status' => "insurance in progress",
          ':trn_start' => $today,
          ':trn_end' => "",
          ':credits' => $amount_standart,
          ':amount' => $amount_standart,
          ':discount_user' => $discount_standart,
          ':discount_medcare' => $medcare_discounts,
          ':percent_for_medcare' => $medcare_percent_for_medcare,
          ':finel_price' => $finel_price,
          ':payed_from' => 'insurance'
      );

      $this->_insert_trn($params);
    }
  }

}
