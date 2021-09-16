<?php


namespace vloop\problems\controllers;

use vloop\problems\entities\cache\CachedEntities;
use vloop\problems\entities\EntitiesWithResetIds;
use vloop\problems\entities\forms\criteria\CriteriaIDEntity;
use vloop\problems\entities\forms\criteria\CriteriaProblemsByDates;
use vloop\problems\entities\forms\criteria\CriteriaReportByProblemId;
use vloop\problems\entities\forms\inputed\AddProblemForm;
use vloop\problems\entities\forms\inputed\AddReport;
use vloop\problems\entities\forms\inputed\ChangeReportDescription;
use vloop\problems\entities\forms\inputed\ChangeStatusProblemForm;
use vloop\problems\entities\problem\decorators\ProblemsByCriteriaForm;
use vloop\problems\entities\problem\ProblemsSQL;
use vloop\problems\entities\report\decorators\ReportsByCriteriaForm;
use vloop\problems\entities\report\ReportsSQL;
use vloop\problems\entities\rest\EntitiesAsJsonApi;
use vloop\problems\entities\rest\ExceprionsAsJsonApi;
use yii\filters\AccessControl;
use yii\rest\Controller;

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
            new ExceprionsAsJsonApi(
                new EntitiesAsJsonApi(
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
            new ExceprionsAsJsonApi(
                new EntitiesAsJsonApi(
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
            new ExceprionsAsJsonApi(
                new EntitiesAsJsonApi(
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
            new ExceprionsAsJsonApi( //если поместить в середину, то программа не прерывается.
                new EntitiesAsJsonApi( //с полями data
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

    public function actionReports(){
        $reports =
            new ExceprionsAsJsonApi(
              new EntitiesAsJsonApi(
                  new ReportsSQL(),
                  'report'
              )
            );
        return $reports->list();
    }

    public function actionAddReport()
    {
        $reports = new ExceprionsAsJsonApi(
            new EntitiesAsJsonApi(
                new ReportsSQL(),
                'report'
            )
        );
        return $reports
            ->add(new AddReport())
            ->printYourself();
    }

    public function actionChangeReport()
    {
        $report =
            new ExceprionsAsJsonApi(
                new EntitiesAsJsonApi(
                    new EntitiesWithResetIds(
                        new CachedEntities(
                            new ReportsByCriteriaForm(
                                new ReportsSQL(),
                                new CriteriaIDEntity()
                            )
                        )
                    ),
                    'problem'
                )
            );
        return $report
            ->entity(0)
            ->changeLineData(new ChangeReportDescription())
            ->printYourself();
    }

    public function actionProblemsByDate()
    {
        $problems =
        new ExceprionsAsJsonApi(
            new EntitiesAsJsonApi(
                new CachedEntities(
                    new ProblemsByCriteriaForm(
                        new CriteriaProblemsByDates()
                    )
                ),
                'problem'
            )
        );
        return $problems->list();
    }

    public function actionReportByProblemId(){
        $reports =
            new ExceprionsAsJsonApi(
                new EntitiesAsJsonApi(
                    new EntitiesWithResetIds(
                        new ReportsByCriteriaForm(
                            new ReportsSQL(),
                            new CriteriaReportByProblemId()
                        )
                    ),
                    'report'
                )
            );
        return $reports->entity(0)->printYourself();
    }
}