<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "subject".
 *
 * @property integer $id
 * @property integer $direction_id
 * @property integer $semester_id
 * @property string $name
 * @property integer $lecturer_id
 * @property integer $practice_id
 * @property integer $lab1_id
 * @property integer $lab2_id
 * @property integer $department_id
 * @property integer $lecture_hour
 * @property integer $practice_hour
 * @property integer $lab_hour
 * @property integer $independent_hour
 *
 * @property Lesson[] $lessons
 * @property Direction $direction
 * @property Term $semester
 * @property Teacher $lecturer
 * @property Teacher $practice
 * @property Teacher $lab1
 * @property Teacher $lab2
 * @property Department $department
 * @property SubjectDirection[] $subjectDirections
 */
class Subject extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'subject';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['direction_id', 'semester_id', 'name', 'lecturer_id', 'practice_id', 'lab1_id', 'lab2_id', 'department_id'], 'required'],
            [['direction_id', 'semester_id', 'lecturer_id', 'practice_id', 'lab1_id', 'lab2_id', 'department_id', 'lecture_hour', 'practice_hour', 'lab_hour', 'independent_hour'], 'integer'],
            [['name'], 'string', 'max' => 64],
            [['direction_id'], 'exist', 'skipOnError' => true, 'targetClass' => Direction::className(), 'targetAttribute' => ['direction_id' => 'id']],
            [['semester_id'], 'exist', 'skipOnError' => true, 'targetClass' => Term::className(), 'targetAttribute' => ['semester_id' => 'id']],
            [['lecturer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Teacher::className(), 'targetAttribute' => ['lecturer_id' => 'id']],
            [['practice_id'], 'exist', 'skipOnError' => true, 'targetClass' => Teacher::className(), 'targetAttribute' => ['practice_id' => 'id']],
            [['lab1_id'], 'exist', 'skipOnError' => true, 'targetClass' => Teacher::className(), 'targetAttribute' => ['lab1_id' => 'id']],
            [['lab2_id'], 'exist', 'skipOnError' => true, 'targetClass' => Teacher::className(), 'targetAttribute' => ['lab2_id' => 'id']],
            [['department_id'], 'exist', 'skipOnError' => true, 'targetClass' => Department::className(), 'targetAttribute' => ['department_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'direction_id' => Yii::t('app', 'Йўналиш'),
            'semester_id' => Yii::t('app', 'Семестр'),
            'name' => Yii::t('app', 'Фан номи'),
            'lecturer_id' => Yii::t('app', 'Маърузачи'),
            'practice_id' => Yii::t('app', 'Амалиётчи'),
            'lab1_id' => Yii::t('app', '1-Лабораториячи'),
            'lab2_id' => Yii::t('app', '2-Лабораториячи'),
            'department_id' => Yii::t('app', 'Кафедра'),
            'lecture_hour' => Yii::t('app', 'Маъруза соат'),
            'practice_hour' => Yii::t('app', 'Амалиёт соат'),
            'lab_hour' => Yii::t('app', 'Тажриба соат'),
            'independent_hour' => Yii::t('app', 'Мустақил соат'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLessons()
    {
        return $this->hasMany(Lesson::className(), ['subject_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDirection()
    {
        return $this->hasOne(Direction::className(), ['id' => 'direction_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSemester()
    {
        return $this->hasOne(Term::className(), ['id' => 'semester_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLecturer()
    {
        return $this->hasOne(Teacher::className(), ['id' => 'lecturer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPractice()
    {
        return $this->hasOne(Teacher::className(), ['id' => 'practice_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLab1()
    {
        return $this->hasOne(Teacher::className(), ['id' => 'lab1_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLab2()
    {
        return $this->hasOne(Teacher::className(), ['id' => 'lab2_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartment()
    {
        return $this->hasOne(Department::className(), ['id' => 'department_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubjectDirections()
    {
        return $this->hasMany(SubjectDirection::className(), ['subject_id' => 'id']);
    }
}
