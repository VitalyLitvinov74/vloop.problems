<?php


namespace vloop\problems\controllers;

use vloop\problems\entities\cache\CachedEntities;
use vloop\problems\entities\EntitiesWithResetIds;
use vloop\problems\entities\exceptions\NotValidatedFields;
use vloop\problems\entities\forms\criteria\CriteriaIDEntity;
use vloop\problems\entities\forms\criteria\CriteriaProblemsByDates;
use vloop\problems\entities\forms\inputed\AddProblemForm;
use vloop\problems\entities\forms\inputed\ChangeStatusProblemForm;
use vloop\problems\entities\forms\inputed\InputsForChangeReport;
use vloop\problems\entities\problem\decorators\ProblemsByCriteriaForm;
use vloop\problems\entities\problem\decorators\ProblemsByDates;
use vloop\problems\entities\problem\ProblemsSQL;
use vloop\problems\entities\report\ReportSQL;
use vloop\problems\entities\report\ReportsSQL;
use vloop\problems\entities\rest\RestEntities;
use vloop\problems\entities\rest\RestEntity;
use vloop\problems\entities\rest\EntitiesWithExceptions;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\VarDumper;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;

class ProblemsController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['access'] = [
            'class' => AccessControl::class,
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['?'], //на время разработки
                ],
            ],
        ];
        return $behaviors;
    }

    public function actionProblems()
    {
        $problems =
            new EntitiesWithExceptions(
                new RestEntities(
                    new CachedEntities(
                        new ProblemsSQL()
                    ),
                    'problem'
                )
            );
        return $problems->list();
    }


    public function actionProblem()
    {
        $problems =
            new EntitiesWithExceptions(
                new RestEntities(
                    new EntitiesWithResetIds(
                        new ProblemsByCriteriaForm(
                            new CriteriaIDEntity('get')
                        )
                    ),
                    'problem'
                )
            );
        return $problems
            ->entity(0)
            ->printYourself();
    }

    public function actionAddProblem()
    {
        $problems =
            new EntitiesWithExceptions(
                new RestEntities(
                    new ProblemsSQL(),
                    'problem'
                )
            );
        return $problems
            ->add(new AddProblemForm())
            ->printYourself();
    }


    public function actionChangeStatus()
    {
        $problems =
            new EntitiesWithExceptions(
                new RestEntities(
                    new EntitiesWithResetIds(
                        new ProblemsByCriteriaForm(
                            new CriteriaIDEntity()
                        )
                    ),
                    'problem'
                )
            );
        return $problems
            ->entity(0)
            ->changeLineData(new ChangeStatusProblemForm())
            ->printYourself();
    }

    public function actionAddReport()
    {
        $reports = new ReportsSQL();
        return $reports
            ->add(new FormReport())
            ->printYourself();
    }

    public function actionChangeReport()
    {
        $report =
            new ReportByCriteriaForm(
                new ReportsSQL(),
                new CriteriaIDEntity()
            );
        return $report
            ->changeLineData(new InputsForChangeReport())
            ->printYourself();
    }

    public function actionProblemsByDate()
    {
        $problems = new ProblemsByDates(
            new ProblemsSQL(),
            new CriteriaProblemsByDates()
        );
        return $problems->list();
    }
}