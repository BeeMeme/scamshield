<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_Tasks extends CI_Model
{
    public function getPendingTasks($userId)
    {
        return $this->db->query("SELECT tasks.*, task_submission.proof FROM tasks, task_submission WHERE tasks.id = task_submission.task_id AND task_submission.user_id = " . $userId . " AND tasks.id NOT IN (SELECT task_id FROM task_history WHERE user_id = " . $userId . ")")->result_array();
    }
    public function getAvailableTasks($userId)
    {
        return $this->db->query("SELECT * FROM tasks WHERE id NOT IN (SELECT task_id FROM task_history WHERE user_id = " . $userId . " UNION SELECT task_id FROM task_submission WHERE user_id = " . $userId . ")")->result_array();
    }
    public function isSubmitted($userId, $taskId)
    {
        return $this->db->get_where('task_submission', ['user_id' => $userId, 'task_id' => $taskId])->num_rows();
    }
    public function isCompleted($userId, $taskId)
    {
        return $this->db->get_where('task_history', ['user_id' => $userId, 'task_id' => $taskId])->num_rows();
    }
    public function addSubmission($taskId, $userId, $proof)
    {
        $proof = [
            'task_id' => $taskId,
            'user_id' => $userId,
            'proof' => $proof,
            'claim_time' => time()
        ];
        $this->db->insert('task_submission', $proof);
    }
    public function updateUser($userId, $usd, $energy)
    {
        $this->db->set('total_earned', 'total_earned+' . $usd, FALSE);
        $this->db->set('balance', 'balance+' . $usd, FALSE);
        $this->db->set('energy', 'energy+' . $energy, FALSE);
        $this->db->where('id', $userId);
        $this->db->update('users');
    }
    public function deleteSubmission($id)
    {
        $this->db->delete('task_submission', ['id' => $id]);
    }
    public function insertHistory($userId, $taskId, $reward)
    {
        $history = [
            'user_id' => $userId,
            'task_id' => $taskId,
            'usd_reward' => $reward,
            'claim_time' => time()
        ];
        $this->db->insert('task_history', $history);
    }
}
